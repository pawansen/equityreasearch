<style>
    .modal-footer .btn + .btn {
    margin-bottom: 5px !important;
    margin-left: 5px;
}
</style>

<div id="commonModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form class="form-horizontal" role="form" id="addFormAjax" method="post" action="<?php echo base_url('users/view_assessment') ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><?php echo (isset($title)) ? ucwords($title) : "" ?></h4>
                </div>
                <div class="modal-body">
                    <div class="loaders">
                        <img src="<?php echo base_url().'backend_asset/images/Preloader_3.gif';?>" class="loaders-img" class="img-responsive">
                    </div>
                    <div class="alert alert-danger" id="error-box" style="display: none"></div>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-12" >
                        <label class="col-md-3 control-label text-success">User Details</label>
                        <hr>

                            <div class="col-md-12" >
                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?php echo lang('organization');  ?></label>
                                        <div class="col-md-9">
                                           <?php if(!empty($result->name)){echo $result->name;}?>
                                        </div>
                                   
                                </div>
                            </div>
                            
                             <div class="col-md-12" >
                                <div class="form-group">
                                   <label class="col-md-3 control-label"><?php echo lang('user');  ?></label>
                                        <div class="col-md-9">
                                           <?php echo $result->first_name.' '.$result->last_name." (".getRole($result->user_id).")";?>
                                        </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang('assessment_name');  ?></label>
                                        <div class="col-md-9">
                                           <?php if(!empty($result->assessment_name)){echo $result->assessment_name;}?>
                                        </div>
                                </div>
                            </div>

                             <div class="col-md-12" >
                               <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang('start_date');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($result->start_date)){echo date('d F Y',strtotime($result->start_date));}?>
                                        </div>
                                </div>
                            </div>

                             <div class="col-md-12" >
                               <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo lang('end_date');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($result->end_date)){echo date('d F Y',strtotime($result->end_date));}?>
                                        </div>
                                </div>
                            </div>


                             <?php if($result->assessment_type == 360) {?>
                                    <div class="col-md-12" >
                                     <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('bullets');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($result->bullets)){echo $result->bullets;}?>
                                        </div>
                                    </div>
                                  </div>  

                                   <div class="col-md-12" >
                                     <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('bullets_in_month');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($result->bullets_in_month_date)){echo $result->bullets_in_month_date;}?>
                                        </div>
                                    </div>
                                  </div>  

                                   <?php }?>

                         </div>   
                           
                     <div class="col-md-12" >
                        <label class="col-md-3 control-label text-success">Questions</label>
                        <hr>
                            <div class="col-md-12" >
                                <div class="form-group">
                                     <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">

                                           <?php $j=1; foreach($questions as $question){

                                              echo $j.' . '; 
                                               echo $question->question; echo "<br/>";
                                           $j++;}?>
                                        </div>
                                </div>
                            </div>

                            </div>

                             
                                <div class="col-md-12" >
                                    <label class="col-md-3 control-label text-success">Upper Level</label>
                                   <hr>
                               <?php if($result->assessment_type == 180) {?>
                                  <div class="col-md-12" >
                                     <div class="form-group">
                                       <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">

                                         <?php $j=1; foreach($upper_lavel as $upper){

                                              echo $j.' . '; 
                                              echo $upper->first_name.' '.$upper->last_name." (".getRole($upper->user_id).")"; echo "<br/>";  
                                           $j++;}?>
                                        </div>
                                    </div>
                                  </div>  

                              <?php }else{?>

                              
                                     <div class="form-group">
                                       
                                        <div class="col-md-9">

                                         <?php $j=1; foreach($upper_lavel as $upper){?>

                                          <label class="col-md-3 control-label"></label><?php
                                              echo $j.' . '; 
                                              echo $upper->first_name.' '.$upper->last_name." (".getRole($upper->user_id).")";  echo "<hr>"; 
                                           $j++; ?>
                                           

                                
                                     <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('bullets');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($upper->bullets)){echo $upper->bullets;}?>
                                        </div>
                                    </div>
                                   

                                 
                                     <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo lang('bullets_in_month');  ?></label>
                                        <div class="col-md-9">

                                          <?php if(!empty($upper->bullets_in_month_date)){echo $upper->bullets_in_month_date;}?>
                                        </div>
                                    </div>
                                  
                              


                                         <?php }?>
                                    </div>
                                </div>
                                     

                                <?php }?>

                                </div>
                               
                            
                          
                          
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div> <!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

