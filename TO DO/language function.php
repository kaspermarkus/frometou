//used to be under layout.php after "<td CLASS='maintableMain'>"





//if $SHOW_PAGE_TRANSLATION is true, show flags for the different translations of the document:
if ($SITE_INFO_LANGS_ENABLED && $SHOW_PAGE_TRANSLATIONS) {
//Create flag to other versions of the document
	echo '<div class="linkflags">';
	foreach ($props['translations'] as $lang=>$trans) {
        	if ($props['lang'] != $lang) {
                	echo "<A HREF='".pageLink($_GET['did'], $lang)."'>";
			echo "<IMG CLASS='linkflags' SRC=\"".$SITE_INFO_PUBLIC_ROOT.$trans['thumbnail_path']."\">";       
			echo "</A>";
        	}
	}
	echo '</div>';
}
