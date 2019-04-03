<?php

session_start();

if (!$_SESSION['nodes']) {
    $_SESSION['nodes'] = [
        [
            'id' => 0,
            'parentId' => null,
            'level' => 0
        ],
    ];
}

$nodes = $_SESSION['nodes'];

$tree = getTree($nodes);
showTree([$tree]);

/**
 * Get tree.
 *
 * @param array $nodes
 * @return array
 */
function getTree(array $nodes): array {
    $tree = $nodes[0];
    treeSetChilds($tree);

    return $tree;
}

/**
 * Set childs.
 *
 * @param array $node
 */
function treeSetChilds(array &$node) {
    $node['childs'] = getChilds($node['id']);
    if($node['childs']) {
        foreach ($node['childs'] as $key => $value) {
            treeSetChilds($node['childs'][$key]);
        }
    }
}

/**
 * Get childs.
 *
 * @param string $nodeId
 * @return array
 */
function getChilds(string $nodeId): array {
    global $nodes;

    $result = [];
    foreach ($nodes as $key => $node) {

        if ($node['parentId'] === $nodeId) {
            $result[$node['id']] = $node;
        }
    }
    return $result;
}

/**
 * Show tree.
 *
 * @param $tree
 */
function showTree(array $tree) {
    foreach ($tree as $item) {
        $name = $item['parentId'] === null ? 'Root' : 'Node';
        echo '<div style="display: inline-block; margin-left: '. $item['level']*50 .'">'.$name.'</div>';
        if ($item['parentId'] !== null) {
            echo '<a href="http://localhost/testTask/add.php?parent_id='.$item['id'].'">+</a>';
            echo '<a href="http://localhost/testTask/remove.php?id='.$item['id'].'">-</a>';
        } else {
            echo '<a href="http://localhost/testTask/add.php?parent_id=0">+</a>';
        }

        echo '<br>';

        if ($item['childs']) {
            showTree($item['childs']);
        }
    }
}