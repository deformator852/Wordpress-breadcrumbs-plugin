<?php

/**
 * Plugin Name: Breadcrumbs
 * Description: Plugin for creating breadcrumbs
 * Author: Me
 * Author URI: https://github.com/deformator852
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

declare(strict_types=1);

function get_breadcrumbs(
	array  $breadcrumbs = [],
	string $sep = '/',
	string $sep_class = 'bc_sep',
	string $container_tag = 'div',
	string $container_class = 'bc_breadcrumbs',
	string $child_class = 'bc_breadcrumbs__child',
	string $first_child_class = 'bc_breadcrumbs__first-child',
	string $last_child_class = 'bc_breadcrumbs__last-child'
): string
{
	if (count($breadcrumbs) < 1) return '';

	$first_breadcrumb = array_shift($breadcrumbs);
	$last_breadcrumb = array_pop($breadcrumbs);

	$first_url = esc_url($first_breadcrumb['url'] ?? '');
	$first_text = esc_html($first_breadcrumb['text'] ?? '');

	$container_class = esc_attr($container_class);
	$container_tag = esc_html($container_tag);
	$child_class = esc_attr($child_class);
	$first_child_class = esc_attr($first_child_class);
	$sep_class = esc_attr($sep_class);

	ob_start();

	echo "<$container_tag class='$container_class'>";

	if (isset($first_url) && isset($last_breadcrumb)) {
		echo "<a href='{$first_url}' class='$child_class $first_child_class'>{$first_text}</a>";
		echo "<span class='$sep_class'>$sep</span>";
	} else {
		echo "<span class='$child_class $first_child_class'>{$first_text}</span>";
		return ob_get_clean();
	}

	foreach ($breadcrumbs as $breadcrumb) {
		$url = esc_url($breadcrumb['url'] ?? '');
		$text = esc_html($breadcrumb['text'] ?? '');

		if ($url) {
			echo "<a href='$url' class='$child_class'>$text</a>";
		} else {
			echo "<span class='$child_class'>$text</span>";
		}

		echo "<span class='$sep_class'>$sep</span>";
	}

	$last_text = esc_html($last_breadcrumb['text'] ?? '');
	echo "<span aria-current='page' class='$child_class $last_child_class'>{$last_text}</span>";

	echo "</$container_tag>";

	return ob_get_clean();
}
