#!/usr/bin/env php
<?php
$installUsage = "Installation usage: ./install.sh <path to phabricator root> <sourcegraph url>\n
";
$uninstallUsage = "Installation usage: ./uninstall.sh <path to phabricator root>\n
";

if ($argc < 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    if ($argv[1] == "rm") {
        echo $uninstallUsage;
    } else {
        echo $installUsage;
    }
    exit(1);
}

$isInstallationScript = boolval(strcmp($argv[1], "rm") !== 0);
$usage = $isInstallationScript ? $installUsage : $uninstallUsage;
$phabRoot = $isInstallationScript ? $argv[1] : $argv[2];

$root = dirname(dirname(dirname(__FILE__))) . '/phabricator-extension-install';

require $root . '/vendor/autoload.php';

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

$codePath = realpath($phabRoot . '/src/applications/base/controller/PhabricatorController.php');

if (!file_exists($codePath)) {
    print "Unable to find paths from '$phabRoot'
Please ensure you provided the correct Phabricator root.
$usage";

    exit(1);
}

$code = file_get_contents($codePath);

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

class SourcegraphNodeVistor extends NodeVisitorAbstract
{
    private $shouldAdd;

    public function __construct($shouldAdd)
    {
        $this->shouldAdd = $shouldAdd;
    }
    public function leaveNode(Node $node)
    {
        if ($node instanceof PhpParser\Node\Stmt\ClassMethod && $node->name == "willBeginExecution") {
            // Check if we've already inserted the expression.
            $hasSourcegraph = false;
            foreach ($node->getStmts() as $idx => $st) {
                if ($st instanceof Node\Expr\FuncCall) {
                    $isFuncName = $st->name->parts[0] == 'require_celerity_resource';
                    $isReqSourcegraph = $st->args[0]->value->value == 'sourcegraph';
                    if ($isFuncName && $isReqSourcegraph) {
                        if (!$this->shouldAdd) {
                            $stmts = $node->getStmts();
                            unset($stmts[$idx]);
                            $reindex = array_values($stmts);
                            $node->stmts = $reindex;
                            return;
                        }
                        $hasSourcegraph = true;
                    }
                }
            }
            // Only insert expression if needed.
            if (!$hasSourcegraph && $this->shouldAdd) {
                $nameNode = new Node\Name('require_celerity_resource');
                $argNode = new Node\Arg(new Node\Scalar\String_('sourcegraph'));
                $newFuncCall = new Node\Expr\FuncCall($nameNode, array($argNode));
                $stmts = array_merge(array($newFuncCall), $node->getStmts());
                $node->stmts = $stmts;
                return $node;
            }
        }
    }
}

$traverser = new NodeTraverser;
$traverser->addVisitor(new SourcegraphNodeVistor($isInstallationScript));
$mod = $traverser->traverse($ast);
$prettyPrinter = new PrettyPrinter\Standard();
$out = $prettyPrinter->prettyPrintFile($mod);

file_put_contents($codePath, $out);

?>
