<?php
/**
 * @file
 * menu.php
 */

define('DRUPAL_ROOT', '../../../../');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo ('<dropdown>
    <settings
    menuColor = "0x' . variable_get('menu_background_color', 'F2F2F2') . ' "
    menuFontColor = "0x' . variable_get('menu_text_color', '525A66') . ' "
    menuFontGlowColor = "0x' . variable_get('menu_hover_color', '7FBFFF') . '"
    subMenuFontColor = "0x' . variable_get('submenu_text_color', '525A66') . '"
    subMenuFontGlowColor = "0x' . variable_get('submenu_hover_color', '7FBFFF') . '"
    >
    </settings>');

$menu_type = variable_get('folder_menu_menu_parent', 'primary-links');
$menus = menu_tree_all_data($menu_type);

foreach ($menus as $menu) {
  $menu_link = $menu['link'];

  if(strstr($menu_link['link_path'],'http'))
    echo '<menu cap="'.$menu_link['title'].'" url = "'.$menu_link['link_path'].'" window = "_self">';
  else
    if($menu_link['link_path'] == '<front>')
    echo '<menu cap="'.$menu_link['title'].'" url = "?q=" window = "_self">';
  else
    echo '<menu cap="'.$menu_link['title'].'" url = "?q='.$menu_link['link_path'].'" window = "_self">';

  $submenus = $menu['below'];
  if ($submenus != false) {
    foreach ($submenus as $submenu) {
      $submenu_link = $submenu['link'];
      if(strstr($submenu_link['link_path'],'http'))
        echo '<submenu cap="'.$submenu_link['title'].'" url = "'.$submenu_link['link_path'].'" window = "_self"></submenu>';
      else
        echo '<submenu cap="'.$submenu_link['title'].'" url = "?q='.$submenu_link['link_path'].'" window = "_self"></submenu>';
    }
  }
  echo '</menu>';
}
echo '</dropdown>';