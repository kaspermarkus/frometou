
<?php
require_once($SITE_INFO_LOCAL_ROOT."functions/cms_link_functions.php");
require_once($SITE_INFO_LOCAL_ROOT."functions/menu_function.php");
require_once($SITE_INFO_LOCAL_ROOT."functions/language_function.php");

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/> 
	<meta http-equiv="Content-Language" content="el">
	<TITLE>
		<?php echo $props->get("pagetitle"); ?>
	</TITLE>
	<link rel="icon" href="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>favicon.ico" type="image/x-icon" />
	<?php 
	include_once("layout.css.php");
	?>
</head>
	<body>
		<center>

			<table CLASS='maintable' cellpadding="0" cellspacing="0">
			  <tbody>
			  	<tr height="20">
			  		<td class="CornerLeftTop"></td>
			  		<td class="CornerCenterTop" colspan="2"></td>
			  		<td class="CornerRightTop"></td>
			  	</tr>

			    <tr>
			  		<td class="CornerLeftCenter" rowspan="3"></td>
			       	<td CLASS='maintableTop'  colspan="2">
				        <span CLASS='maintableTop'>
				        <IMG CLASS='maintableTop' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>imgs/tree.png" />
				        <IMG CLASS='maintableTop' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>imgs/frometou.png" />					        
				        <IMG CLASS='maintableTop' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>imgs/treeRotate.png" />
				        </span>
				        <div class="maintableTopLanguage">
							<?php if ($SITE_INFO_LANGS_ENABLED) { insert_page_translations(); } ?>
							<?php echo generate_direct_cms_link(); ?>
						</div>
						<hr>
					</td>
			  		<td rowspan="3" class="CornerRightCenter"></td>

			    </tr>
			    <tr>

			        <td CLASS='maintableLeft'>
			        	<div  CLASS='maintableLeftMenu'>
							<?php echo leftMenu(); ?>
			        	</div>
				 	</td>
				 	<td CLASS='maintableMain'>
						<?php require_once($SITE_INFO_LOCAL_ROOT.$props->get("display_path")); ?>
					</td>
				</tr>
				<tr>
					 <td CLASS='maintableBottom' COLSPAN=2>
						The Ninjas / all over the place 14, japan / 666 nuclear waste / tlf: xxxxxx / e-mail: <a href="mailto:ninja@markus.dk">ninja@markus.dk</a>
					 </td>
				</tr>

			  	<tr height="30">
			  		<td class="CornerLeftBottom"></td>
			  		<td class="CornerCenterBottom" colspan="2"></td>
			  		<td class="CornerRightBottom"></td>
			  	</tr>

			  <tbody>
			</table>

		</center>
	</BODY>
</HTML>
