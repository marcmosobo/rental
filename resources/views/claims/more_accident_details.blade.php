<?php
$fields = \App\Models\ClaimField::where('status',true)->get();

$parents = $fields->where('parent_id',null);
if(count($parents)){
//    echo '<div class="row">';
    foreach ($parents as $parent){
        echo '<div class="form-group col-md-3">';

        echo '<div class="col-md-12">';
        echo '<div class="col-md-12"><label>'.$parent->field.'</label></div>';
            $children = $fields->where('parent_id',$parent->id);
            if(count($children)){
                foreach ($children as $child){
                    echo '<div class="col-md-12" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="'.$parent->value.'" value="'.$child->value.'"><label>'.$child->value.'</label></div>';
                }
            }
        echo '</div>';
        echo '</div>';
    }
//    echo '</div>';
}



?>

