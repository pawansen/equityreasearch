<div class="form-group" id="<?php echo $key_id;?>">
    <div class="col-md-offset-5 text-danger"><i class="fa fa-arrow-circle-o-down"></i> Parent</div>
    <label class="col-md-3 control-label">Upper Level</label>
    <div class="col-md-8" id="upper-lavel-input">

        <select class="form-control" name="upper_level_user[]" id="upper_level_user" style="width:100%">
            <?php if(!empty($users)){
                    foreach($users as $user){?>
                        
            <option value="<?php echo $user->id;?>"><?php echo $user->name;?></option>
            
                   <?php }
            }?>
        </select>

    </div>
    <div class="col-md-1"><a class="btn btn-danger" onclick="remove_upper('<?php echo $key_id;?>')"><i class="fa fa-minus-circle"></i></a></div>
</div>
