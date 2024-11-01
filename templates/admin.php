<?php

if(!defined('ABSPATH') || !current_user_can('manage_options')){
  echo '<meta http-equiv="refresh" content="0; url=/404">';
  die('404 Page Not Found');
}

global $SwiftNinjaProSettings_PluginName;
$SwiftNinjaProSettings_PluginName = 'Comments';
$SwiftNinjaProSettings_PluginDisplayName = 'Comments';
$SwiftNinjaProSettings_PluginPermalinkName = 'comments';

$SwiftNinjaProSettingAdminOnly = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption_only('AdminOnly'));

if(!current_user_can('administrator') && $SwiftNinjaProSettingAdminOnly){
  die('Only Administrators Are Allowed To Access These Settings!');
}

?>

<style>
.swiftninjaro-settings-pre{
    border: solid 3px #2b333d;
    border-radius: 10px;
    font-size: 14px;
    color: #3c3d3c;
    margin: 2%;
    padding: 10px;
    background: #eaeaea;
    display: block;
    font-family: monospace;
    white-space: pre-wrap;
    width: 85%;
}

.swiftninjapro-settings-button {
  all: initial;
  all: unset;
  border: solid 2px #3a3a3a;
  color: #f7f7f7;
  background: #2877c1;
  border-radius: 10px;
  font-size: 30px;
  padding: 10px;
}

.swiftninjapro-settings-button:hover {
  border: solid 2px #0f0f0f;
  color: #e8e8e8;
  background: #2269aa;
}
</style>

<datalist id="SwiftNinjaProSettingsColorPicker">
  <option value="#FF0000">
  <option value="#FFC0CB">
  <option value="#FFA500">
  <option value="#FFD700">
  <option value="#FFFF00">
  <option value="#800080">
  <option value="#00FF00">
  <option value="#008000">
  <option value="#00FFFF">
  <option value="#ADD8E6">
  <option value="#0000FF">
  <option value="#00008B">
  <option value="#8B4513">
  <option value="#FFFFFF">
  <option value="#D3D3D3">
  <option value="#A9A9A9">
  <option value="#808080">
  <option value="#000000">
</datalist>

<?php

echo "<h1>SwiftNinjaPro $SwiftNinjaProSettings_PluginDisplayName</h1>";

if(!isset($_GET['UpdateOptions']) && isset($_GET['settings'])){
  if(esc_html($_GET['settings']) === 'session-error'){
    echo '<h2>Error: Failed to save settings! Session Expired!</h2>';
  }else if(esc_html($_GET['settings']) === 'saved'){
    echo '<h2>Successfully Saved Settings!</h2>';
  }
}

if(isset($_GET['UpdateOptions']) && (!isset($_POST['SwiftNinjaProSettingsToken']) || (esc_html($_POST['SwiftNinjaProSettingsToken']) !== esc_html($_COOKIE['SwiftNinjaProSettingsToken']) && esc_html($_POST['SwiftNinjaProSettingsToken']) !== esc_html($_REQUEST['SwiftNinjaProSettingsToken'])))){
  echo '<script>window.location.replace("'.esc_url(get_admin_url()).'admin.php?page=swiftninjapro-'.$SwiftNinjaProSettings_PluginPermalinkName.'&settings=session-error");</script>';
  exit('<h2>Error: Failed to save settings! Session Expired!</h2>');
}
$SwiftNinjaProSettingsToken = esc_html(wp_generate_password(64));
$SwiftNinjaProSettingsDomain = preg_replace('/^https?:\/\//', '', esc_url(get_admin_url()));
$SwiftNinjaProSettingsDomain = explode('/', $SwiftNinjaProSettingsDomain, 2);
setcookie('SwiftNinjaProSettingsToken', $SwiftNinjaProSettingsToken, 0, '/'.$SwiftNinjaProSettingsDomain[1], $SwiftNinjaProSettingsDomain[0]);


//get and update options
$SwiftNinjaProSettingsAdminOnly = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('AdminOnly', 'administrator', $SwiftNinjaProSettings_PluginName));
$SwiftNinjaProSettingsEnabled = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('Enabled', 'manage_options', $SwiftNinjaProSettings_PluginName));

$SwiftNinjaProSettingsAllowImage = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('AllowImage', 'manage_options', $SwiftNinjaProSettings_PluginName));
$SwiftNinjaProSettingsAllowURL = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('AllowURL', 'manage_options', $SwiftNinjaProSettings_PluginName));
$SwiftNinjaProSettingsAllowColorText = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('AllowColorText', 'manage_options', $SwiftNinjaProSettings_PluginName));

$SwiftNinjaProSettingsShowDay = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('ShowDay', 'manage_options', $SwiftNinjaProSettings_PluginName));

$SwiftNinjaProSettingsShowCommentCount = SwiftNinjaPro_settings_GetOption('ShowCommentCount', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsCommentWordRequirement = SwiftNinjaPro_settings_GetOption('CommentWordRequirement', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsCommentCharMax = SwiftNinjaPro_settings_GetOption('CommentCharMax', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsCommentRequireLogin = SwiftNinjaProSettingsTrueText(SwiftNinjaPro_settings_GetOption('CommentRequireLogin', 'manage_options', $SwiftNinjaProSettings_PluginName));

$SwiftNinjaProSettingsColorCBoxB = SwiftNinjaPro_settings_GetOption('ColorCBoxB', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorCBoxT = SwiftNinjaPro_settings_GetOption('ColorCBoxT', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorCBoxIconSize = SwiftNinjaPro_settings_GetOption('ColorCBoxIconSize', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorCBoxIconPos = SwiftNinjaPro_settings_GetOption('ColorCBoxIconPos', 'manage_options', $SwiftNinjaProSettings_PluginName);

$SwiftNinjaProSettingsColorBBoxBa = SwiftNinjaPro_settings_GetOption('ColorBBoxBa', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorBBoxT = SwiftNinjaPro_settings_GetOption('ColorBBoxT', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorBBoxBo = SwiftNinjaPro_settings_GetOption('ColorBBoxBo', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorBBoxBaH = SwiftNinjaPro_settings_GetOption('ColorBBoxBaH', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorBBoxTH = SwiftNinjaPro_settings_GetOption('ColorBBoxTH', 'manage_options', $SwiftNinjaProSettings_PluginName);
$SwiftNinjaProSettingsColorBBoxBoH = SwiftNinjaPro_settings_GetOption('ColorBBoxBoH', 'manage_options', $SwiftNinjaProSettings_PluginName);


if(isset($_GET['UpdateOptions'])){
  echo '<script>window.location.replace("'.esc_url(get_admin_url()).'admin.php?page=swiftninjapro-'.$SwiftNinjaProSettings_PluginPermalinkName.'&settings=saved");</script>';
  exit('<h2>Successfully Saved Settings!</h2>');
}

function SwiftNinjaPro_settings_GetOption($name, $requiredPermToUpdate){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($name, $pluginName);
  $option = get_option($sName);
  if(isset($option) && ($option || $option === false || $option === '')){
    $option = esc_html($option);
  }else{$option = null;}
  if(isset($_GET['UpdateOptions'])){
    $post = esc_html($_POST[$sName]);
    if(current_user_can($requiredPermToUpdate)){update_option($sName, $post);}
    return $post;
  }else{return $option;}
}

function SwiftNinjaPro_settings_GetOption_only($name){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($name, $pluginName);
  $option = get_option($sName);
  if(isset($option) && $option){
    $option = esc_html($option);
  }else{$option = null;}
  return $option;
}

function SwiftNinjaPro_settings_SetOption($name, $pluginName){
  return esc_html('SwiftNinjaPro'.$pluginName.'_'.$name);
}

function SwiftNinjaProSettingsTrueText($text){
  if($text === 'true' || $text === 'TRUE' || $text === 'True' || $text === true || $text === 1 || $text === 'on'){
    return true;
  }else{return false;}
}


//option display functions
function SwiftNinjaProSettingAddCheckBox($setting, $option, $text, $default=false){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($option, $pluginName);
  $set;
  if($setting !== null){
    $set = SwiftNinjaProSettingsTrueText($setting);
  }else{$set = $default;}
  if($set){
    echo '<input type="checkbox" name="'.$sName.'" checked="true"><strong>'.$text.'</strong></input>';
  }else{
    echo '<input type="checkbox" name="'.$sName.'"><strong>'.$text.'</strong></input>';
  }
}

function SwiftNinjaProSettingAddList($setting, $option, $text, $default=false){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($option, $pluginName);
  $set;
  if(isset($setting) && $setting && $setting !== ''){
    $set = $setting;
  }else if($default){
    $set = $default;
  }else{$set = '';}
  $result = '<textarea class="swiftninjapro-settings-textarea" name="'.$sName.'" rows="10" cols="20" placeholder="'.$text.'">';
  $result = $result.$set;
  $result = $result.'</textarea>';
  echo $result;
}

function SwiftNinjaProSettingAddInput($setting, $option, $text, $default, $inputSize, $placeholder = false, $type = "text"){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($option, $pluginName);
  $setValue;
  if($setting){
    $setValue = $setting;
  }else{$setValue = $default;}

  $setPlaceholder = $text;
  if($placeholder){
    $setPlaceholder = $placeholder;
  }

  $result = '<strong>'.$text.' </strong>';
  $result .= '<input type="'.$type.'" name="'.$sName.'" placeholder="'.$setPlaceholder.'" value="'.$setValue.'" style="border-radius: 10px; width: '.$inputSize.';"/>';

  echo $result;
}

function SwiftNinjaProSettingAddColorPicker($setting, $option, $text, $default=false){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($option, $pluginName);
  $setColor;
  if($setting){
    $setColor = $setting;
  }else{$setColor = $default;}
  $result = '<strong>'.$text.' </strong>';
  $result .= '<input type="color" id="swiftninjapro-colorpickerselect-'.$option.'" name="'.$sName.'" value="'.$setColor.'" style="padding: 1px; width: 75px; height: 25px;" list="SwiftNinjaProSettingsColorPicker" onchange="swiftninjaproSettingSetColorPicker'.$option.'(this.value)">';
  $result .= '</input>';
  $result .= ' <input id="swiftninjapro-colorpickerinput-'.$option.'" maxlength="7" placeholder="#hex" value="'.$setColor.'" style="border-radius: 10px; width: 100px;" onpaste="swiftninjaproSettingSetColorPicker'.$option.'(this.value)" oninput="swiftninjaproSettingSetColorPicker'.$option.'(this.value)"></input>';
  $result .= '<script>function swiftninjaproSettingSetColorPicker'.$option.'(value){var select = document.getElementById("swiftninjapro-colorpickerselect-'.$option.'"); var input = document.getElementById("swiftninjapro-colorpickerinput-'.$option.'"); select.value = value; input.value = value;}</script>';

  echo $result;
}

function SwiftNinjaProSettingAddSelect($setting, $option, $text, $default, $optionList, $optionNameList){
  global $SwiftNinjaProSettings_PluginName;
  $pluginName = $SwiftNinjaProSettings_PluginName;
  $sName = SwiftNinjaPro_settings_SetOption($option, $pluginName);
  $setValue;
  if($setting){
    $setValue = $setting;
  }else{$setValue = $default;}
  $result = '<strong>'.$text.' </strong>';
  $result .= '<select id="'.$option.'" name="'.$sName.'" style="border-radius: 10px;">';
  for($i = 0; $i < count($optionList); $i++){
    $name = $optionList[$i];
    if($optionNameList[$i] != ""){
      $name = $optionNameList[$i];
    }
    if($optionList[$i] == $setValue){
      $result .= '<option value="'.$optionList[$i].'" selected>'.$name.'</option>';
    }else{$result .= '<option value="'.$optionList[$i].'">'.$name.'</option>';}
  }
  $result .= '</select>';
  echo $result;
}


echo '<form action="'.esc_url(get_admin_url()).'admin.php?page=swiftninjapro-'.$SwiftNinjaProSettings_PluginPermalinkName.'&UpdateOptions" autocomplete="off" method="POST" enctype="multipart/form-data">';
echo '<input type="hidden" name="SwiftNinjaProSettingsToken" value="'.$SwiftNinjaProSettingsToken.'">';

SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsEnabled, 'Enabled', 'Plugin Enabled', true);
echo '<br>';
SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsAdminOnly, 'AdminOnly', 'Restrict Settings To Administrator');
echo '<br><br>';

echo '<h2>shortcode examples:</h2>';
echo '<h4>[comments]</h4>';
echo '<h3>other shortcode options:</h3>';
echo '<h4>[comments query="var"]</h4>';
echo '<h4>[comments query="userprofile"]</h4>';
echo '<h4>[comments query="(insert query var to base comments on)"]</h4>';
echo '<br><br>';

SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsAllowImage, 'AllowImage', 'Allow Images to be Embeded in Comments');
echo '<br>';
SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsAllowURL, 'AllowURL', 'Allow URL\'s to be Embeded in Comments');
echo '<br>';
SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsAllowColorText, 'AllowColorText', 'Allow Colored Text in Comments');

echo '<br><br>';

SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsShowDay, 'ShowDay', 'Show the day each comment was posted');

echo '<br>';

echo '<pre class="swiftninjaro-settings-pre">';
echo '<h2>Spam Control</h2>';
SwiftNinjaProSettingAddInput($SwiftNinjaProSettingsShowCommentCount, 'ShowCommentCount', 'Number Of Comments To Show', '', '100px', 'false', 'number');
echo '<br>';
SwiftNinjaProSettingAddInput($SwiftNinjaProSettingsCommentWordRequirement, 'CommentWordRequirement', 'Minimum Word Count', '', '100px', '1', 'number');
echo '<br>';
SwiftNinjaProSettingAddInput($SwiftNinjaProSettingsCommentCharMax, 'CommentCharMax', 'Maximum Characters', '', '100px', '1000', 'number');
echo '<br>';
SwiftNinjaProSettingAddCheckBox($SwiftNinjaProSettingsCommentRequireLogin, 'CommentRequireLogin', 'Only Allow Logged In Users To Post Comments');
echo '</pre>';

echo '<pre class="swiftninjaro-settings-pre">';
echo '<h2>Comment Layout</h2>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorCBoxB, 'ColorCBoxB', 'Background Color', '#f2f2f2');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorCBoxT, 'ColorCBoxT', 'Text Color', '#1e1e1e');
echo '<br>';
SwiftNinjaProSettingAddInput($SwiftNinjaProSettingsColorCBoxIconSize, 'ColorCBoxIconSize', 'Icon Size', '45px', '120px');
echo '<br>';
SwiftNinjaProSettingAddInput($SwiftNinjaProSettingsColorCBoxIconPos, 'ColorCBoxIconPos', 'Icon Position', 'left', '120px');
echo '</pre>';

echo '<pre class="swiftninjaro-settings-pre">';
echo '<h2>Button Colors</h2>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxBa, 'ColorBBoxBa', 'Background Color', '#2172af');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxBo, 'ColorBBoxBo', 'Border Color', '#232323');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxT, 'ColorBBoxT', 'Text Color', '#efefef');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxBaH, 'ColorBBoxBaH', 'Hover Background Color', '#2379ba');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxBoH, 'ColorBBoxBoH', 'Hover Border Color', '#2b2b2b');
echo '<br>';
SwiftNinjaProSettingAddColorPicker($SwiftNinjaProSettingsColorBBoxTH, 'ColorBBoxTH', 'Hover Text Color', '#f9f9f9');
echo '</pre>';

echo '<br><br><input type="submit" value="Save" class="swiftninjapro-settings-button">';
echo '</form>';

?>
