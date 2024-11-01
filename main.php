<?php
/**
* @package SwiftNinjaProComments
*/

if(!defined('ABSPATH') || !defined('SITE_DIRECT_swiftninjapro-plugin')){
  echo '<script>window.location.replace("/404");</script>';
  echo '<meta http-equiv="refresh" content="0; url=/404">';
  die('404 Page Not Found');
}

if(!class_exists('SwiftNinjaProCommentsMain')){

class SwiftNinjaProCommentsMain{
  
  public $pluginSettingsName;
  public $pluginShortcode;
  
  private $globalScriptsAdded = false;
  
  function start($pluginSettingsName, $pluginShortcode){
    $this->pluginSettingsName = $pluginSettingsName;
	  $this->pluginShortcode = $pluginShortcode;
    if($pluginShortcode){add_shortcode($pluginShortcode, array($this, 'add_plugin_shortcode'));}
  }
  
  function removeDefaultComments(){
    add_filter('comments_open', array($this, 'disable_comments_status'), 20, 2);
    add_filter('pings_open', array($this, 'disable_comments_status'), 20, 2);
    add_filter('comments_array', array($this, 'disable_comments_hide_existing_comments'), 10, 2);
  }
  
  function disable_comments_status() {
    return false;
  }
  
  function disable_comments_hide_existing_comments($comments){
    $comments = array();
    return $comments;
  }
  
  function add_global_scripts(){
    
    $this->removeDefaultComments();
    
    $colorBackground = '#2172af';
    $colorText = '#efefef';
    $colorBorder = '#232323';
    $colorBackgroundH = '#2379ba';
    $colorTextH = '#f9f9f9';
    $colorBorderH = '#2b2b2b';
    
    $optionColorBackground = $this->settings_getOption('ColorBBoxBa');
    $optionColorText = $this->settings_getOption('ColorBBoxT');
    $optionColorBorder = $this->settings_getOption('ColorBBoxBo');
    $optionColorBackgroundH = $this->settings_getOption('ColorBBoxBaH');
    $optionColorTextH = $this->settings_getOption('ColorBBoxTH');
    $optionColorBorderH = $this->settings_getOption('ColorBBoxBoH');
    
    if($optionColorBackground){$colorBackground = $optionColorBackground;}
    if($optionColorText){$colorText = $optionColorText;}
    if($optionColorBorder){$colorBorder = $optionColorBorder;}
    if($optionColorBackgroundH){$colorBackgroundH = $optionColorBackgroundH;}
    if($optionColorTextH){$colorTextH = $optionColorTextH;}
    if($optionColorBorderH){$colorBorderH = $optionColorBorderH;}
    
    $globalScriptsAdded = true;
    $scripts = '<style>';
    $scripts .= '.commentPostButton{animation: none !important; animation-delay: 0 !important; animation-duration: 0 !important; box-shadow: none !important; background: '.$colorBackground.' !important; border: solid 2px '.$colorBorder.' !important; border-radius: 10px !important; padding: 5px 10px !important; color: '.$colorText.' !important; font-size: 20px !important;}';
    $scripts .= '.commentPostButton:hover{background: '.$colorBackgroundH.' !important; border: solid 2px '.$colorBorderH.' !important; border-radius: 10px !important; padding: 5px 10px !important; color: '.$colorText.' !important; font-size: 20px !important;}';
    $scripts .= '#comments{display: none;}';
    $scripts .= '</style>';
    
    return $scripts;
  }
  
  function addCommentPages($commentLimit, $commentID, $location, $count){
    $limit = $commentLimit;
    if($commentLimit < 1){
      $limit = 1;
    }
    
    $pageLimit = $count/$limit;
    
    $result = '<input type="button" class="commentPostButton" id="NinjaBackComment'.$location.'" style="float: left !important; visibility: hidden;" onclick="ninjaBackComment()" value="<-- Previous Comment">';
    $result .= '<input type="button" class="commentPostButton" id="NinjaNextComment'.$location.'" style="float: right !important;" onclick="ninjaNextComment()" value="Next Comment -->">';
    $result .= '<script>';
    $result .= 'var NinjaBackComment'.$location.' = document.getElementById("NinjaBackComment'.$location.'"); var NinjaNextComment'.$location.' = document.getElementById("NinjaNextComment'.$location.'");';
    if($location == 'top'){
      $result .= 'var currentNinjaCommentPage = "1"; var currentNinjaCommentPageLimit = "'.$pageLimit.'";';
      $result .= 'var ninjaCommentIdList = [];';
      $result .= 'var ninjaCommentPageStart = 0; var ninjaCommentPageEnd = '.$limit.';';
      for($i = 0; $i < count($commentID); $i++){
        $result .= 'ninjaCommentIdList.push("'.$commentID[$i].'");';
      }
      $result .= 'function ninjaBackComment(){ninjaSetComments("down", 1);}';
      $result .= 'function ninjaNextComment(){ninjaSetComments("up", 1);}';
      $result .= 'function ninjaSetComments(direction, amount){';
      $result .= 'if(direction == "down"){currentNinjaCommentPage = Number(currentNinjaCommentPage)-Number(amount);}else if(direction == "up"){currentNinjaCommentPage = Number(currentNinjaCommentPage)+Number(amount);}';
      $result .= 'if(currentNinjaCommentPage <= 1){NinjaBackCommenttop.style.visibility = "hidden"; NinjaBackCommentbottom.style.visibility = "hidden";}else{NinjaBackCommenttop.style.visibility = "visible"; NinjaBackCommentbottom.style.visibility = "visible";}';
      $result .= 'if(currentNinjaCommentPage >= currentNinjaCommentPageLimit){NinjaNextCommenttop.style.visibility = "hidden"; NinjaNextCommentbottom.style.visibility = "hidden";}else{NinjaNextCommenttop.style.visibility = "visible"; NinjaNextCommentbottom.style.visibility = "visible";}';
      $result .= 'for(i=ninjaCommentPageStart; i<ninjaCommentPageEnd; i++){var ninjaElement = document.getElementById("comment-"+ninjaCommentIdList[i]); if(ninjaElement){ninjaElement.style.display = "none";}}';
      $result .= 'if(direction == "down"){ninjaCommentPageStart -= '.$limit.'*amount; ninjaCommentPageEnd -= '.$limit.'*amount;}else if(direction == "up"){ninjaCommentPageStart += '.$limit.'*amount; ninjaCommentPageEnd += '.$limit.'*amount;}';
      $result .= 'for(i=ninjaCommentPageStart; i<ninjaCommentPageEnd; i++){var ninjaElement = document.getElementById("comment-"+ninjaCommentIdList[i]); if(ninjaElement){ninjaElement.style.display = "block";}}';
      $result .= '}';
    }
    $result .= '</script>';
    
    return $result;
  }
  
  function add_plugin_shortcode($atts = ''){
    $value = shortcode_atts(array('query' => false,), $atts);
    $query = htmlentities($value["query"]);
    
    $useQuery = false;
    $queryspecific = false;
    
    if($query){
      $useQuery = htmlentities($_GET[$query]);
      $queryspecific = true;
    }
    
    $initPage = 1;
    if(isset($_GET["cpage"])){
      $initPage = htmlentities($_GET["cpage"]);
    }else if(isset($_POST["cpage"])){
      $initPage = htmlentities($_POST["cpage"]);
    }
    
    $postComment = false;
    
    if(isset($_POST["ninjaPostComment"])){
      $postComment = htmlentities($_POST["ninjaPostComment"]);
    }
    
    $commentLimit = false;
    $optionCommentLimit = $this->settings_getOption('ShowCommentCount');
    if($optionCommentLimit && $optionCommentLimit >= 1){
      $commentLimit = $optionCommentLimit;
    }
    
    global $post;
    
    $postID = $post->ID;
    
	$commentRequireLogin = false;
    $optionCommentRequireLogin = $this->settings_getOption('CommentRequireLogin', true);
    if($optionCommentRequireLogin){$commentRequireLogin = $optionCommentRequireLogin;}
    
    if($postComment && !is_user_logged_in() && $commentRequireLogin){
      unset($_POST["ninjaPostComment"]);
      echo '<script>window.location.replace("'.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'");</script>';
      echo '<meta http-equiv="refresh" content="0; url='.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'">';
      exit();
    }
	
    $commentWordRequirement = 1;
    $optionCommentWordRequirement = $this->settings_getOption('CommentWordRequirement');
    if($optionCommentWordRequirement && $optionCommentWordRequirement > 1){
      $commentWordRequirement = $optionCommentWordRequirement;
    }
    
    if($postComment && str_word_count(htmlentities($postComment)) < $commentWordRequirement){
      unset($_POST["ninjaPostComment"]);
      echo '<script>window.location.replace("'.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'");</script>';
      echo '<meta http-equiv="refresh" content="0; url='.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'">';
      exit();
    }
    
    
    $commentCharMax = 1000;
    $optionCommentCharMax = $this->settings_getOption('CommentCharMax');
    if($optionCommentCharMax && $optionCommentCharMax > 1){
      $commentCharMax = $optionCommentCharMax;
    }else if($optionCommentCharMax && $optionCommentCharMax < 1){
      $commentCharMax = 0;
    }
    
    if($postComment && $commentCharMax > 0 && strlen(htmlentities($postComment)) > $commentCharMax){
      unset($_POST["ninjaPostComment"]);
      echo '<script>window.location.replace("'.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'");</script>';
      echo '<meta http-equiv="refresh" content="0; url='.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'">';
      exit();
    }
    
    
    if($postComment){
      $totalCommentCount = -1;
      foreach(get_comments() as $comment){
        if($totalCommentCount == -1){
          $totalCommentCount = htmlentities($comment->comment_ID);
        }else{break;}
      }
      $this->post_new_comment($postComment, $totalCommentCount+1, $useQuery, $postID);
    }
    
    
    $currentComments = array();
    
    $commentCount = 0;
    $commentContent = array();
    $commentAuthor = array();
    $commentAuthorID = array();
    $commentID = array();
    
    foreach(get_comments(array('post_id' => $post->ID, 'status' => 'approve')) as $comment){
      $commentContent[$commentCount] = $this->htmlentitiesURL($comment->comment_content, true);
      $commentAuthor[$commentCount] = htmlentities($comment->comment_author);
      $commentAuthorID[$commentCount] = htmlentities($comment->user_id);
      $commentID[$commentCount] = htmlentities($comment->comment_ID);
      $commentCount++;
    }
    
    $newCommentCount = 0;
    
    $currentCommentID = array();
    
    for($i = 0; $i < $commentCount; $i++){
      if($queryspecific){
        if(strpos($commentContent[$i], '[ninja_query]'.$useQuery.'[/ninja_query]') !== false){
          $currentComments[$newCommentCount] = $this->get_comment($commentAuthor[$i], $commentContent[$i], $commentAuthorID[$i], $commentID[$i], false, $commentLimit, $newCommentCount, $initPage);
          $currentCommentID[$newCommentCount] = $commentID[$i];
          $newCommentCount++;
        }else if(strpos($commentContent[$i], '[ninja_query]') === false && !$useQuery){
          $currentComments[$newCommentCount] = $this->get_comment($commentAuthor[$i], $commentContent[$i], $commentAuthorID[$i], $commentID[$i], true, $commentLimit, $newCommentCount, $initPage);
          $currentCommentID[$newCommentCount] = $commentID[$i];
          $newCommentCount++;
        }
      }else{
        if(strpos($commentContent[$i], '[ninja_query]') === false){
          $currentComments[$newCommentCount] = $this->get_comment($commentAuthor[$i], $commentContent[$i], $commentAuthorID[$i], $commentID[$i], true, $commentLimit, $newCommentCount, $initPage);
          $currentCommentID[$newCommentCount] = $commentID[$i];
          $newCommentCount++;
        }else{
          $currentComments[$newCommentCount] = $this->get_comment($commentAuthor[$i], $commentContent[$i], $commentAuthorID[$i], $commentID[$i], false, $commentLimit, $newCommentCount, $initPage);
          $currentCommentID[$newCommentCount] = $commentID[$i];
          $newCommentCount++;
        }
      }
    }
    
    $result = '<br>';
    
    if($commentLimit && $commentLimit < $newCommentCount){
      $result .= $this->addCommentPages($commentLimit, $currentCommentID, 'top', $newCommentCount);
      $result .= '<br><br>';
    }
    
    for($i = 0; $i < $newCommentCount; $i++){
      $result .= $currentComments[$i];
    }
    
    if($commentLimit && $commentLimit < $newCommentCount){
      $result .= $this->addCommentPages($commentLimit, $currentCommentID, 'bottom', $newCommentCount);
      $result .= '<br><br>';
    }
    
    $result .= $this->add_comment_post($commentWordRequirement);
    
    if(!$globalScriptsAdded){
      $result .= $this->add_global_scripts();
    }
    
    if($commentLimit && $commentLimit < $newCommentCount && $initPage > 1){
      $result .= '<script>ninjaSetComments("up", '.($initPage-1).');</script>';
    }
    
    $result .= '<br>';
    
    return $result;
  }
  
  function post_new_comment($comment, $nextID, $query, $postID){
    
    $currentUserName;
    $currentUserID;
    $currentUserEmail;
    
    $domain_parts = explode('.', $_SERVER['HTTP_HOST']);
    $domain = htmlentities($domain_parts[count($domain_parts)-2].'.'.$domain_parts[count($domain_parts)-1]);
    
    if(is_user_logged_in()){
      global $current_user; wp_get_current_user();
      $currentUserName = htmlentities($current_user->display_name);
      $currentUserID = htmlentities($current_user->ID);
      $current_user = wp_get_current_user();
      $currentUserEmail = htmlentities($current_user->user_email);
    }else{
      $currentUserName = 'Guest';
      $currentUserID = -1;
      $currentUserEmail = 'guest@'.$domain;
    }
    
    $flagHtml = false;
    if($_POST["ninjaPostComment"] != strip_tags($_POST["ninjaPostComment"]) || $query != strip_tags($query)){
      $flagHtml = true;
    }
    
    $postText = '';
    if($flagHtml){$postText .= '[warning]Comment May Contain HTML[/warning]'."\n";}
    if($query && $query !== ''){$postText .= '[ninja_query]'.strip_tags(htmlentities($query)).'[/ninja_query]';}
    $postText .= strip_tags(htmlentities($comment));
    
    $time = htmlentities(current_time('mysql'));
    
    if($flagHtml){
      $commentdata = array(
	  'comment_post_ID' => strip_tags(htmlentities($postID)),
	  'comment_author' => strip_tags(htmlentities($currentUserName)),
	  'comment_author_email' => strip_tags(htmlentities($currentUserEmail)),
	  'comment_content' => strip_tags(wp_strip_all_tags(htmlentities($postText))),
	  'comment_parent' => 0,
	  'user_id' => strip_tags(htmlentities($currentUserID)),
      'comment_author_IP' => strip_tags(wp_strip_all_tags(htmlentities($_SERVER['REMOTE_ADDR']))),
      'comment_date' => strip_tags(htmlentities($time)),
      'comment_approved' => 0,
      );
    }else{
      $commentdata = array(
        'comment_post_ID' => $postID,
        'comment_author' => $currentUserName,
        'comment_author_email' => $currentUserEmail,
        'comment_content' => $postText,
        'comment_parent' => 0,
        'user_id' => $currentUserID,
        'comment_author_IP' => htmlentities($_SERVER['REMOTE_ADDR']),
        'comment_date' => $time,
      );
    }
    
    wp_insert_comment($commentdata);
    
    unset($_POST["ninjaPostComment"]);
    echo '<script>window.location.replace("'.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'");</script>';
    echo '<meta http-equiv="refresh" content="0; url='.esc_url(strip_tags($_SERVER['REQUEST_URI'])).'">';
    exit();
  }
  
  function add_comment_post($wordRequirement){
    $colorB = "#f2f2f2";
    $colorT = "#1e1e1e";
    
    $optionColorB = $this->settings_getOption('ColorCBoxB');
    $optionColorT = $this->settings_getOption('ColorCBoxT');
    if($optionColorB){$colorB = $optionColorB;}
    if($optionColorT){$colorT = $optionColorT;}
    
    $allowImage = $this->settings_getOption('AllowImage', true);
    $allowURL = $this->settings_getOption('AllowURL', true);
    $allowColorText = $this->settings_getOption('AllowColorText', true);
    
	  $commentRequireLogin = false;
    $optionCommentRequireLogin = $this->settings_getOption('CommentRequireLogin', true);
    if($optionCommentRequireLogin){$commentRequireLogin = $optionCommentRequireLogin;}
	
    $commentCharMax = 1000;
    $optionCommentCharMax = $this->settings_getOption('CommentCharMax');
    if($optionCommentCharMax && $optionCommentCharMax > 1){
      $commentCharMax = $optionCommentCharMax;
    }else if($optionCommentCharMax && $optionCommentCharMax < 1){
      $commentCharMax = 0;
    }
    
	
    $http;
    if(isset($_SERVER['HTTPS'])){
      $http = 'https://';
    }else{$http = 'http://';}
    
    $url = $http.esc_html(strip_tags($_SERVER['HTTP_HOST']));
    
    $includeS = '';
    if($wordRequirement > 1){$includeS = 's';}
    
    $result = '<pre style="font-family: Arial, Helvetica, sans-serif; padding: 30px; font-size: 15px; white-space: pre-wrap; word-break: keep-all; position: relative; border: bold 2px; border-radius: 10px; display: block; background: '.htmlentities($colorB).'; color: '.htmlentities($colorT).'; box-shadow: 0 0 5px #121212;">';
    $result .= '<form action="" method="post">';
    $result .= '<pre style="font-family: Arial, Helvetica, sans-serif; padding: 10px; font-size: 15px; white-space: pre-wrap; word-break: keep-all; position: relative; border: bold 2px; border-radius: 10px; display: block; background: '.htmlentities($colorB).'; color: '.htmlentities($colorT).';">';
    $result .= '[b] <strong>Bold</strong> [/b] [i] <em>Italic</em> [/i] [u] <u>Underlined</u> [/u] [s] <strike>Strikethrough</strike> [/s]';
    if($allowColorText){$result .= ' [c="red"] <font color="red">Color</font> [/c]';}
    if($allowURL){$result .= '<br>[url="<a href="'.$url.'">'.$url.'</a>"] <a href="'.$url.'">Url Link</a> [/url]';}
    if($allowImage){$result .= '<br>[img] <a href="'.$url.'/ImageUrl">'.$url.'/ImageUrl</a> [/img]';}
    if($wordRequirement > 1){$result .= '<br><br>Comments Must Contain At Least '.$wordRequirement.' Word'.$includeS;}
	  if($commentRequireLogin && !is_user_logged_in()){$result .= '<br>You Must Be Logged In To Leave A Comment';}
    $result .='</pre>';
    $result .= '<br><textarea';
    if($commentCharMax && $commentCharMax > 0){$result .= ' maxlength="'.strip_tags($commentCharMax).'"';}
    $result .= ' name="ninjaPostComment" type="text" rows="10" cols="100" style="min-height: 5em; max-height: 50vh; width: 100%; resize: none;"></textarea>';
    $result .= '<br>';
    $result .= '<input type="submit" value="Post Comment" class="commentPostButton">';
    $result .= '</form>';
    $result .= '</pre>';
    
    return $result;
  }
  
  function get_comment($author, $text, $userID, $commentID, $isOld, $commentLimit, $commentCount, $initPage){
    
    $showText;
    if($isOld){
      $showText = $this->htmlentitiesURL($text, true);
    }else{
      if(strpos($text, '[ninja_comment]') !== false){
        $showText = $this->htmlentitiesURL($this->get_string_between($text, '[ninja_comment]', '[/ninja_comment]'), true);
      }else if(strpos($text, '[/ninja_query]') !== false){
        $showText = $this->htmlentitiesURL(substr($text, strpos($text, '[/ninja_query]') + 14), true);
      }else{
        $showText = $this->htmlentitiesURL($text, true);
      }
    }
    
    $visibleDisplay;
    if($commentLimit && $commentLimit >= $commentCount && $initPage > 1){
      $visibleDisplay = "block";
    }else if(!$commentLimit){
      $visibleDisplay = "block";
    }else if($initPage <= 1 && $commentCount < $commentLimit){
      $visibleDisplay = "block";
    }else{$visibleDisplay = "none";}
    
    $commentDay = htmlentities(get_comment_date("F jS, Y", $commentID));
    
    $authorURL = htmlentities(get_author_posts_url($userID, $author));
    
    $showDay = $this->settings_getOption('ShowDay', true);
    $showCommentUrl = true;
    
    $colorB = "#f2f2f2";
    $colorT = "#1e1e1e";
    $iconSize = "45px";
    $iconPosition = "left";
    
    $optionColorB = $this->settings_getOption('ColorCBoxB');
    $optionColorT = $this->settings_getOption('ColorCBoxT');
    $optionIconSize = $this->settings_getOption('ColorCBoxIconSize');
    $optionIconPosition = $this->settings_getOption('ColorCBoxIconPos');
    
    if($optionColorB){$colorB = $optionColorB;}
    if($optionColorT){$colorT = $optionColorT;}
    if($optionIconSize){$iconSize = $optionIconSize;}
    if($optionIconPosition){$iconPosition = $optionIconPosition;}
    
    $result = '<pre id="comment-'.htmlentities($commentID).'" style="display: '.$visibleDisplay.' !important; font-family: Arial, Helvetica, sans-serif; padding: 20px; font-size: 15px; white-space: pre-wrap; word-break: keep-all; position: relative; border: bold 2px; border-radius: 10px; display: block; background: '.htmlentities($colorB).'; color: '.htmlentities($colorT).'; box-shadow: 0 0 5px #121212; margin-bottom: 10px;">';
    
    $result .= '<img src="'.htmlentities(get_avatar_url($userID)).'" style="border: none; background: none; padding: 0; float: '.htmlentities($iconPosition).'; width: '.htmlentities($iconSize).'; height: '.htmlentities($iconSize).';"></img>';
    $result .= '<a href="'.htmlentities($authorURL).'"><strong>  '.htmlentities($author).'  </strong></a>';
    if($showDay){
      $result .= htmlentities($commentDay);
    }
    
    $result .= '<br>';
    
    if($showCommentUrl){
      $result .= '   <a href="#comment-'.htmlentities($commentID).'">Link</a>';
    }
    
    $result .= '<br><br>'.$this->fixText(esc_html__($showText)).'<br>';
    
    $result .= '</pre>';
    
    return $result;
  }
  
  function fixText($text){
    $allowImage = $this->settings_getOption('AllowImage', true);
    $allowURL = $this->settings_getOption('AllowURL', true);
    $allowColorText = $this->settings_getOption('AllowColorText', true);
    
    $newText = htmlentities($text);
    
    $newText = str_replace("\n", "<br>", $newText);
    
    $newText = $this->swapTag($newText, 'b', 'strong');
    $newText = $this->swapTag($newText, 'i', 'em');
    $newText = $this->swapTag($newText, 'u');
    $newText = $this->swapTag($newText, 's', 'strike');
    
    if($allowImage){
      $newText = str_replace("[img]", "<img style=\"border: 0; padding: 0;\" src=\"", $newText);
      $newText = str_replace("[/img]", "\"></img>", $newText);
    }
    
    if($allowURL){
      $newText = $this->replace_string_parts($newText, 'img', 'a', 'href');
      
      $newText = $this->replace_string_parts($newText, 'url', 'a', 'href');
      $newText = $this->replace_string_parts($newText, 'url', 'a', 'link', 'href');
      $newText = $this->replace_string_parts($newText, 'url', 'a', 'useTag', 'href');
    }
    
    $newText = str_replace("[img]", "", $newText);
    $newText = str_replace("[/img]", "", $newText);
    
    if($allowColorText){
      $newText = $this->replace_string_parts($newText, 'c', 'font', 'useTag', 'color');
    }
    
    return $newText;
  }
  
  function trueText($text){
    if($text === 'true' || $text === 'TRUE' || $text === 'True' || $text === true || $text === 1 || $text === 'on'){
      return true;
    }else{return false;}
  }
  
  function swapTag($string, $oldTags, $newTags = false){
	$oldTag = htmlentities($oldTags);
	$newTag = htmlentities($newTags);
	
    $newText = $string;
    if($newTag){
      $newText = str_replace("[".$oldTag."]", "<".$newTag.">", $newText);
      $newText = str_replace("[/".$oldTag."]", "</".$newTag.">", $newText);
    }else{
      $newText = str_replace("[".$oldTag."]", "<".$oldTag.">", $newText);
      $newText = str_replace("[/".$oldTag."]", "</".$oldTag.">", $newText);
    }
    return $newText;
  }
  
  function htmlentitiesURL($url, $addQuots){
    $link = htmlspecialchars_decode($url);
    $link = str_replace('&quot;', '[ninja_quot]', $link);
    $link = str_replace('/', '[ninja_slash]', $link);
    $link = htmlentities($link);
    $link = str_replace('[ninja_slash]', '/', $link);
    if($addQuots){
      $link = str_replace('[ninja_quot]', '"', $link);
    }else{
      $link = str_replace('[ninja_quot]', '', $link);
    }
    
    return strip_tags($link);
  }
  
  function replace_string_parts($string, $oldTags, $newTags, $parameter, $parameterNew = false){
	$oldTag = htmlentities($oldTags);
	$newTag = htmlentities($newTags);
	
    $newText = $string;
    $tagCount;
    if($parameter != 'useTag'){
      $tagCount = substr_count($newText, '['.$oldTag.' '.$parameter.'=');
    }else{
      $tagCount = substr_count($newText, '['.$oldTag.'=');
    }
    if($tagCount > 0){
      for($i = 0; $i < $tagCount; $i++){
        $link;
        $linkNew;
        $text2;
        if($parameter != 'useTag'){
          $link = $this->get_string_between($newText, '['.$oldTag.' '.$parameter.'=', ']');
          $linkNew = $this->htmlentitiesURL($link, false);
          $text2 = htmlentities($this->get_string_between($newText, '['.$oldTag.' '.$parameter.'='.$link.']', '[/'.$oldTag.']'));
        }else{
          $link = $this->get_string_between($newText, '['.$oldTag.'=', ']');
          $linkNew = $this->htmlentitiesURL($link, false);
          $text2 = htmlentities($this->get_string_between($newText, '['.$oldTag.'='.$link.']', '[/'.$oldTag.']'));
        }
        
        if(!$parameterNew && $parameter != 'useTag'){
          $newText = str_replace('['.$oldTag.' '.$parameter.'='.$link.']'.$text2.'[/'.$oldTag.']', '<'.$newTag.' '.$parameter.'="'.htmlentities($linkNew).'">'.$text2.'</'.$newTag.'>', $newText);
        }else if($parameter != 'useTag'){
          $newText = str_replace('['.$oldTag.' '.$parameter.'='.$link.']'.$text2.'[/'.$oldTag.']', '<'.$newTag.' '.$parameterNew.'="'.htmlentities($linkNew).'">'.$text2.'</'.$newTag.'>', $newText);
        }else{
          $newText = str_replace('['.$oldTag.'='.$link.']'.$text2.'[/'.$oldTag.']', '<'.$newTag.' '.$parameterNew.'="'.htmlentities($linkNew).'">'.$text2.'</'.$newTag.'>', $newText);
        }
      }
    }else{
      $tagCount = substr_count($newText, '['.$oldTag.']');
      if($tagCount > 0){
        for($i = 0; $i < $tagCount; $i++){
          $link = $this->get_string_between($newText, '['.$oldTag.']', '[/'.$oldTag.']');
          if(!$parameterNew){
            $newText = str_replace('['.$oldTag.']'.$link.'[/'.$oldTag.']', '<'.$newTag.' '.$parameter.'="'.htmlentities($link).'">'.htmlentities($link).'</'.$newTag.'>', $newText);
          }else{
            $newText = str_replace('['.$oldTag.']'.$link.'[/'.$oldTag.']', '<'.$newTag.' '.$parameterNew.'="'.htmlentities($link).'">'.htmlentities($link).'</'.$newTag.'>', $newText);
          }
        }
      }
    }
    
    return $newText;
  }
  
  function get_string_between($string, $start, $end, $startPos = 1, $endPos = 1){
    $cPos = 0;
    $ini = 0;
    $result = '';
    $sPos = 0;
    $ePos = 0;
    for($i = 0; $i < $startPos; $i++){
      $ini = strpos($string, $start, $sPos);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $sPos = $ini;
    }
    $nString = substr($string, $sPos);
    for($i = 0; $i < $endPos; $i++){
      $ini = strpos($nString, $end, $ePos);
      if ($ini == 0) return '';
      $ini += strlen($end);
      $ePos = $ini;
    }
    $result = substr($nString, 0, $ePos - strlen($end));
    return $result;
  }
  
  function settings_getOption($name, $trueText = false){
    $sName = $this->settings_setOptionName($name);
    $option = htmlentities(get_option($sName));
    if($trueText){$option = $this->trueText($option);}
    return $option;
  }

  function settings_setOptionName($name){
    return htmlentities('SwiftNinjaPro'.$this->pluginSettingsName.'_'.$name);
  }
  
}

  $swiftNinjaProCommentsMain = new SwiftNinjaProCommentsMain();

}
