<?php
/**
 * @file
 * This file generate xml that contains menus structure and appearance
 * parameters which were set in Drupal module settings page.
 */

$str = getcwd();
$str = implode("\\", explode("/", $str));
$back_string = '';
$index = strpos($str, '\\sites\\');
while (strpos($str, '\\', $index)) {
  $back_string .= '../';
  $index = strpos($str, '\\', $index) + 1;
}

define('DRUPAL_ROOT', $back_string);
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo ('<dropdown>
    <settings
    menuColor = "0x' . variable_get('folder_menu_background_color', 'F2F2F2') . ' "
    menuFontColor = "0x' . variable_get('folder_menu_text_color', '525A66') . ' "
    menuFontGlowColor = "0x' . variable_get('folder_menu_hover_color', '7FBFFF') . '"
    subMenuFontColor = "0x' . variable_get('folder_menu_submenu_text_color', '525A66') . '"
    subMenuFontGlowColor = "0x' . variable_get('folder_menu_submenu_hover_color', '7FBFFF') . '"
    >
    </settings>');

$menu_type = variable_get('folder_menu_parent', 'primary-links');
$menus = menu_tree_all_data($menu_type);

foreach ($menus as $menu) {
  $menu_link = $menu['link'];
  if ($menu_link['hidden'] == 0) {
    if (strstr($menu_link['link_path'], 'http')) {
      echo '<menu cap="' . check_plain($menu_link['title']) . '" url = "' . check_url($menu_link['link_path']) . '" window = "_self">';
    }
    else {
      if ($menu_link['link_path'] == '<front>') {
        echo '<menu cap="' . check_plain($menu_link['title']) . '" url = "?q=" window = "_self">';
      }
      else {
        echo '<menu cap="' . check_plain($menu_link['title']) . '" url = "?q=' . check_url($menu_link['link_path']) . '" window = "_self">';
      }
    }

    $submenus = $menu['below'];
    if ($submenus != FALSE) {
      foreach ($submenus as $submenu) {
        $submenu_link = $submenu['link'];
        if ($submenu_link['hidden'] == 0) {
          if (strstr($submenu_link['link_path'], 'http')) {
            echo '<submenu cap="' . check_plain($submenu_link['title']) . '" url = "' . check_url($submenu_link['link_path']) . '" window = "_self"></submenu>';
          }
          else {
            echo '<submenu cap="' . check_plain($submenu_link['title']) . '" url = "?q=' . check_url($submenu_link['link_path']) . '" window = "_self"></submenu>';
          }
        }
      }
    }
    echo '</menu>';
  }
}
echo '</dropdown>';
