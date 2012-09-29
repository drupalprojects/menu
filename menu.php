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

chdir($back_string);
require_once 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo ('<dropdown>
    <settings
    menuColor = "0x' . variable_get('folder_menu_background_color', 'F2F2F2') . '"
    menuFontColor = "0x' . variable_get('folder_menu_text_color', '525A66') . '"
    menuFontGlowColor = "0x' . variable_get('folder_menu_hover_color', '7FBFFF') . '"
    subMenuFontColor = "0x' . variable_get('folder_menu_submenu_text_color', '525A66') . '"
    subMenuFontGlowColor = "0x' . variable_get('folder_menu_submenu_hover_color', '7FBFFF') . '"
    >
    </settings>');
$menu_type = variable_get('folder_menu_parent', 'primary-links');
$menus = menu_tree_all_data($menu_type);

foreach ($menus as $menu) {
  $menulink = $menu['link'];
  if ($menulink['hidden'] == 0) {
    if (strstr($menulink['link_path'], 'http')) {
      echo '<menu cap="' . check_plain($menulink['title']) . '" url = "' . check_url($menulink['link_path']) . '" window = "_self">';
    }
    else {
      echo '<menu cap="' . check_plain($menulink['title']) . '" url = "?q=' . check_url($menulink['link_path']) . '" window = "_self">';
    }

    $submenus = $menu['below'];
    if ($submenus != FALSE) {
      foreach ($submenus as $submenu) {
        $submenulink = $submenu['link'];
        if($submenulink['hidden'] == 0) {
          if (strstr($submenulink['link_path'], 'http')) {
            echo '<submenu cap="' . check_plain($submenulink['title']) . '" url = "' . check_url($submenulink['link_path']) . '" window = "_self"></submenu>';
          }
          else {
            echo '<submenu cap="' . check_plain($submenulink['title']) . '" url = "?q=' . check_url($submenulink['link_path']) . '" window = "_self"></submenu>';
          }
        }
      }
    }
    echo '</menu>';
  }
}
echo '</dropdown>';
