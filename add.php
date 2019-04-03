<?php

session_start();

$parent = find($_GET['parent_id']);

if ($parent) {
    $parentId = $parent['id'];
    $level = $parent['level'] + 1;
} else {
    $parentId = 0;
    $level = 1;
}

$_SESSION['nodes'][] = [
    'id' => md5(time() . rand(0, 100000)),
    'parentId' => $parentId,
    'level' => $level
];

header('Location: /');

/**
 * Find node.
 *
 * @param int $id
 * @return bool
 */
function find(int $id) {
    $nodes = $_SESSION['nodes'];

    foreach ($nodes as $node) {
        if ($node['id'] === $id) {
            return $node;
        }
    }

    return false;
}
