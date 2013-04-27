<?php

class doc {
    function add($category, $query) {
        //echo $query;
        $result = mysql_query($query);
        if ($result && mysql_num_rows($result) > 0) {
            $prev = isset($this->data[$category]) ? $this->data[$category] : [];
            $this->data[$category] = array_merge($prev, mysql_fetch_assoc($result));
            //print_r($this->data);
            return true;
        }
        return false;
    }

    function get($key, $category="baseData") {
        return (isset($this->data[$category]) && isset($this->data[$category][$key])) ? $this->data[$category][$key] : NULL;
    }

    function show($key, $category="baseData") {
        echo (isset($this->data[$category]) && isset($this->data[$category][$key])) ? $this->data[$category][$key]  : "";
    }

    function load($did) {
        if (!isset($did)) {
            echo $did;
            die();
            header("location:listDocs.php");

        }
        $this->did = $did;
        $this->add("baseData", "SELECT doc.module_signature, doc.did, doc.priority, module_name, cms_path, ident, description_img ".
            "FROM doc, module ".
            "WHERE doc.module_signature = module.module_signature AND doc.did=".$did);
         //load module:
        require_once($this->get("cms_path"));
        $module_sig = $this->get("module_signature");
        $module = new $module_sig;
        $this->data['modules'][$module_sig] = new $module_sig;
        $this->loadTranslation($_SESSION['lang']);
    }

    function loadTranslation($lang) {
        $this->data["baseData"]["lang"] = $lang;
        $query = "SELECT linktext, description, pagetitle ";
        $query .= "FROM doc_general_v WHERE did=".$this->get('did')." AND langid='".$lang."'";
        $this->add("baseData", $query);
        foreach($this->data['modules'] as $n=>$o) {
            $o->load($this->get('did'), $lang);
        }
    }

    function save($post, $lang) {
        //first update the general properties:
        $query = "UPDATE doc SET priority = ".$post['priority'].", ident=\"".$post['ident']."\", description_img=\"".$post['description_img']."\" WHERE did='".$this->get("did")."'";
        //echo $query;
        mysql_query($query);
        //update translation specific general properties
        $query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$post['did'].", '".$lang."', \"".$post['linktext']."\", \"".$post['pagetitle']."\", \"".$post['description']."\")"; 
        //echo $query."<br />";        
        mysql_query($query);
        foreach($this->data['modules'] as $n=>$o) {
            $o->save($post, $lang);
        }
        //reinitialize this object, as we've changed some of the base information
        $this->load($this->get("did"));
    }

    function delete() {
        mysql_query("DELETE FROM doc WHERE did=$this->did");
        mysql_query("DELETE FROM doc_general_v WHERE did=$this->did");
        mysql_query("DELETE FROM mappings WHERE did=$this->did");
        //also delete module entry:
        foreach($this->data['modules'] as $n=>$o) {
            $o->delete();
        }
    }

    function deleteLang($langid) {
        //echo "DELETE FROM doc_general_v WHERE did=$this->did AND langid='$langid'";
        mysql_query("DELETE FROM doc_general_v WHERE did=$this->did AND langid='$langid'");
        //also delete module entry:
        foreach($this->data['modules'] as $n=>$o) {
            $o->deleteLang($langid);
        }       
    }

    function printEditArea() {
        global $SITE_INFO_PUBLIC_ROOT;
        ?>
        <input type='hidden' name="did" value="<?php $this->show('did'); ?>">
                <TD WIDTH=0><INPUT TYPE="submit" value="&nbsp;save changes &nbsp;" name="saveDoc"></TD><br><br>
        <TABLE BORDER=0 id="standardInfo" WIDTH=100%>
            <tr>
                <th>Public Url:</th>
                <th>
                    <?php
                    $url = $SITE_INFO_PUBLIC_ROOT.$_SESSION['lang']."/page".$this->get('did');
                    echo "<a href=\"$url\">$url</a>";
                    ?>
                </th>
                   <TD ROWSPAN=6 STYLE="vertical-align:top; text-align:left;">
                    <input type='hidden' NAME='description_img' id="description_img_form_field" VALUE="<?php $this->show('description_img'); ?>" name='description_img' />
                    <A HREF="#" class="kfm" onClick="javascript:update_description_img()">
                        <IMG WIDTH='150px' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT.($this->get('description_img')?$this->get('description_img'):'layout/imgs/no_img.svg'); ?>" id="description_img" />
                    </A>
                    <script language='javascript'>
                        function update_description_img() {
                            window.SetUrl = (function (id) {
                                return function (value) {
                                    document.getElementById('description_img').src = value;
                                    var public_root = <?php echo "/".str_replace("/", '\/', $SITE_INFO_PUBLIC_ROOT)."/"; ?>;
                                    value = value.replace(public_root, '');
                                    document.getElementById('description_img_form_field').value = value;
                                }
                            })(this.id) 
                            window.open("lib/elFinder/elfinder.html?frometou=docImage",'elf','modal,width=600,height=400');
                        }
                    //kfm_init();
                    </script>
                </TD>
            </tr>
            <tr>
                <th>identifier: </th>
                <td>
                    <input TYPE='text' size="50" name="ident" value="<?php $this->show('ident'); ?>">
                </td>
            </tr>
            <tr>
                   <th STYLE="width:0; text-align:right;">priority: </th>
                   <td WIDTH=100%><input TYPE='text' size="3" name="priority" value="<?php $this->show('priority'); ?>"></td>
            </tr>
            <TR>
                <TH>page title:</TH>
                <TD>
                    <input size="50" name="pagetitle" value="<?php $this->show("pagetitle"); ?>">
                </TD>
            </tr>
            <tr>
                <TH>linktext:</TH>
                <TD><input size="50" name="linktext" value="<?php $this->show("linktext"); ?>"></TD>
            </tr>
            <tr>
                <TH>description: </TH>
                <TD>
                    <TEXTAREA COLS=50 ROWS=3 NAME='description'><?php $this->show("description"); ?></TEXTAREA>
                </TD>
            </tr>
        </table>
        <?php
            foreach($this->data['modules'] as $n=>$o) {
            $o->printEditArea();
        }
        //mainmenu checkbox
        // require_once("modules/mainmenu.php");
        // $mod = new mainmenu;
        // echo $mod->checkMainMenu($this->get('did'));
       echo "<br><INPUT TYPE='submit' value='&nbsp;save changes &nbsp;' name='saveDoc' />";
    }
}