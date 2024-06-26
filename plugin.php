<?php

/**
 * Content boxes plugin for Bludit 3.15.0
 * Author: Crysanthus
 * License: MIT
 * Version: 1.0
 * Release Date: 2024-06-18
 * Website: https://crysanthus.blogspot.com
 * GitHub: https://github.com/crysanthus
 */

class pluginContentBoxes extends Plugin
{

	/**
	 * Initializes the plugin with default database fields for 'nosboxes' and 'noschars'.
	 *
	 */
	public function init()
	{
		$this->dbFields = array(
			'nosboxes' => 6,
			'noschars' => 50
		);
	}

	/**
	 * Renders the form for the plugin settings page.
	 *
	 * @return string The HTML content for the form.
	 */
	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>' . $L->get('Number of content boxes') . '</label>';
		$html .= '<input name="nosboxes" type="number" value="' . $this->getValue('nosboxes') . '">';
		$html .= '<span class="tip">' . $L->get('A number of content boxes to display') . '</span>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>' . $L->get('Number of characters in a content box') . '</label>';
		$html .= '<input name="noschars" type="number" value="' . $this->getValue('noschars') . '">';
		$html .= '<span class="tip">' . $L->get('A number of characters from the article/post to display') . '</span>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Renders the content boxes at the end of the site.
	 *
	 * @return string The HTML content for the content boxes.
	 */
	public function siteBodyEnd()
	{
		global $pages;

		$startPageNumber = 1;
		$numberOfPages = $this->getValue('nosboxes');
		$onlyPublishedPages = true;

		$items = $pages->getList($startPageNumber, $numberOfPages, $onlyPublishedPages);

		$html  = '<div class="container">';
		$html .= '<div class="row">';

		foreach ($items as $key) {

			$page = buildPage($key);
			$contentToDisplay = substr(strip_tags($page->content()), 0, $this->getValue('noschars'));

			$html .= '<div class="col-md-3 m-1 mb-2 py-1 border rounded shadow">';
			$html .= '<div class="panel panel-default">';
			$html .= '<div class="panel-heading">';
			$html .= '<div class="h4 panel-title">';
			$html .= '<a class="text-dark h4" href="' . $page->permalink() . '">' . $page->title() . '</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="panel-body">';
			$html .= $contentToDisplay . ' ...';
			$html .= '<a href="' . $page->permalink() . '"> more</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}
