<?php

$params = $vars;

$params['show_sort'] = false;
$params['show_search'] = false;

$params['sort'] = 'last_action::desc';

$time = time() - 600;

$params['options']['wheres'][] = function(\Elgg\Database\QueryBuilder $qb, $alias) use ($time) {
	return $qb->compare("{$alias}.last_action", '>=', $time, ELGG_VALUE_INTEGER);
};

echo elgg_view('lists/users', $params);
