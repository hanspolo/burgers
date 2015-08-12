<?php
/**
 * Created by     Eric Fernance
 * User:          Digital Garage
 * Website:       http://digital-garage.com.au
 * License:       GPLv2
 * File:          nav.php
 */


class Nav
{

	protected static $items;

	/**
	 * Used to build the nav bar based on the table defined in the config.  Requires a user in the session and checks user group.
	 * @param mixed $db A database object
	 */

	public static function build($db = null)
	{
		$f3    = \Base::instance();
		$table = $f3->get('MENUTABLE');
		$user  = $f3->get('SESSION.user');

		if (!$db)
		{
			$db = $f3->get('DB');
		}

		if (!$table)
		{
			throw new \Exception("MENUTABLE config item is needed");
		}

		if (!$user)
		{
			throw new \Exception("User not set in session.  Please set SESSION.user");
		}

		if (!$db)
		{
			throw new \Exception("DB not available in session and not passed to build.");
		}

		$groupId = $user['groupId'];

		// Get a list of all top level items the user group has access to
		$items = $db->exec("select * from " . $table . " where access_level <= " . (int)$groupId . " and parent_id=0");
		foreach ($items as &$item)
		{
			// Load the children
			$item['children'] = $db->exec("select * from " . $table . " where access_level <= ". (int)$groupId . " and parent_id=" . (int)$item['id']);
		}

		self::$items = $items;

	}

	/**
	 * Renders the navbar as html.
	 * @param string $style  What style to use -- by default plain html but can also be bootstrapped.
	 */

	public static function render($style = '')
	{
		if (!self::$items)
		{
			throw new \Exception("Build menu with Nav::build() before rendering");
		}

		$class       = ($style == 'bootstrap') ? 'nav navbar-nav' : '';

		$html = "<ul class='$class'>";

		// Loop through the items
		foreach (self::$items as $item)
		{
			$hasChildren = (isset($item['children']) && count($item['children']) > 0);

			// Open parent li
			$class  = ($style == 'bootstrap' && $hasChildren) ? 'dropdown' : '';
			$html .= '<li class="' . $class  . '"><a href="' . $item['link'] . '"';

			if ($style == 'bootstrap' && $hasChildren)
			{
				$html .= 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
			}

			$html .= '>' . $item['anchor'];
			if ($style == 'bootstrap' && $hasChildren)
			{
				$html .= ' <span class="caret"></span> ';
			}
			$html .= '</a>';

			// Check for children
			if ($hasChildren)
			{
				// Open children ul
				$class = ($style == 'bootstrap') ? 'dropdown-menu' : '';
				$html .= '<ul class="' . $class  . '">';

				foreach ($item['children'] as $child)
				{
					// Add each child
					$html .= '<li><a href="' . $child['link'] . '">' . $child['anchor'] . '</a></li>';
				}

				// Close children ul
				$html .= '</ul>';
			}

			// Close parent li
			$html .= '</li>';
		}


		$html .= "</ul>";

		return $html;


	}



}