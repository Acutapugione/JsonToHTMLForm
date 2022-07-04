<?php
function GetHTMLFooter(array $array = null)
{
    $footer_html='
    <script language="JavaScript" type="text/javascript">
        function HandleBrowseClick()
        {
            var fileinput = document.getElementById("browse");
            fileinput.click();
        }
        function Handlechange()
        {
        var fileinput = document.getElementById("browse");
        var textinput = document.getElementById("filename");
        textinput.value = fileinput.value;
        }
    </script>';
}
function GetHTMLFieldGroup(array $group = null)
{
    
    $fields_html = "";
    $form_fields = "";
    if(isset($group['fields'])){
        foreach ($group['fields'] as $field) {
            if(!isset($field['name']))
                continue;
            
            if(isset($field['position'])){
                $allowed_types = array_filter(
                    $field['allowed_file_types'],
                    function($val){
                        return $val == true;
                    }
                );
                //accept=".png, .jpg, .jpeg"
                $accept_str = '';
                $allowed_types_str = '';
                foreach($allowed_types as $type){
                    foreach ($type as $key => $val) {
                        if(strlen($allowed_types_str)>0){
                            $allowed_types_str = sprintf('%s/%s',  $allowed_types_str, str_replace(':','',$key));
                            $accept_str = sprintf('%s, .%s', $accept_str, str_replace(':','',$key));
                        }
                        else{
                            $allowed_types_str = sprintf('(%s%s',  $allowed_types_str, str_replace(':','',$key));
                            $accept_str = sprintf('%s.%s', $accept_str, str_replace(':','',$key));
                        }
                    }
                }
                $accept_str = sprintf('accept=\'%s\'', $accept_str);
                
                $allowed_types_str = sprintf('%s)',  $allowed_types_str);

                $form_fields = sprintf(
                    '%s 
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="%s">%s</label>
                            <input type="file" class="form-control custom-file-input" id="%s" data-chooseText="Update %s %s %s" %s %s>
                        </div>
                    </div>
                    ',
                    $form_fields,//prev form_fields
                    $field['name'],//label target
                    $field['position']. '. '.$field['name'],//.' '.$field['description'],//label text                    
                    
                    $field['name'],//input id
                    $retVal = (//input chooseText
                        (isset($field['quantity_max'])
                        &&!is_null($field['quantity_max'])
                        ) ? $field['quantity_max']
                         : $field['quantity_min'].' or more ' ), 
                    $field['field_type'],//input chooseText
                    $allowed_types_str,//input chooseText
                    $required =(    //input required
                         (isset($field['required']) 
                         && ($field['required'] == true)
                         ) ? 'required'
                         : ''),
                    $accept_str //input accept
                );
                
            }else{
                //todo: add <li>
            }
        }
    }
    
    $card_form_group = sprintf(
    '<div class="card bg-light mb-3">
            <div class="card-header">
                %s
            </div>
            <div class="card-body">
                <div class="card-title">
                    <p class="card-text">
                        %s
                    </p>
                    <p class="card-text">
                        %s
                    </p>
                </div> 
                <div class="card-footer">
                    %s
                </div>
            </div>
    </div>',
    $group['name'],
    $group['description'],
    $group['directory_prefix'],
    $form_fields
    );
    return $card_form_group;
}
function GetHTMLMain(array $array = null)
{
    $main_html = '<form>
    <input type="hidden" name="json" value="/structure.json"/>';

    if(isset($array['field_groups'])){
        foreach ($array['field_groups'] as $group) {
           $main_html = sprintf("%s %s", $main_html, GetHTMLFieldGroup($group));            
        }
    }
        
    $main_html = sprintf("%s %s", $main_html, "</form>");
    return $main_html;
}
function GetHTMLTitle(array $array = null)
{
    $title_html = "";
    if (isset($array['title'])){
        $title_html = sprintf("
            %s<h1 id='doc_title'>
            %s
            </h1>",
            $title_html, $array['title']);
    }
    if (isset($array['description'])){
        $title_html = sprintf("
            %s<h2 id='doc_description'>
            %s
            </h2>",
            $title_html, $array['description']);
    }
    if (isset($array['text'])){
        $title_html = sprintf("
            %s<p id='doc_text'>
            %s
            </p>",
            $title_html, $array['text']);
    }
    if (isset($array['valid_from'])){
        if(isset($array['valid_to']) && !is_null($array['valid_to'])){
            $title_html = sprintf("
            %s<p id='doc_valid_timespan'>
            %s - %s
            </p>",
            $title_html, $array['valid_from'], $array['valid_to']);
        }else{
            $title_html = sprintf("
            %s<p id='doc_valid_timespan'>
            %s
            </p>",
            $title_html, $array['valid_from']);
        }
    }

    if(isset($array['versions'])){
        $title_html = sprintf("%s<p>", $title_html);
        foreach ( $array["versions"] as $item ) {
            foreach( $item as $key=>$val){
                $title_html = sprintf("%s %s", $title_html, $val );
            }
        }
        $title_html = sprintf("%s</p>", $title_html);
    }

    return $title_html;
}
function GetHTMLFromArray(array $array = null)
{
    $title = GetHTMLTitle($array);
    $body = GetHTMLMain($array);
    $footer = GetHTMLFooter($array);
    return sprintf("%s %s %s", $title, $body, $footer);
}
?>