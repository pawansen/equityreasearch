<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($headline)) ? ucwords($headline) : "" ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo lang('home'); ?></a>
            </li>
            <li>
                <a href="<?php echo site_url('users/assessment'); ?>"><?php echo lang('user_assessment'); ?></a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="wrapper wrapper-content animated fadeInRight">
                                <div class="col-md-12"><span class="text-info"><?php echo $_GET['u'];?></span> => 
                                    <span class='text-danger'><?php echo $_GET['a'];?></span><hr></div>
                                
                                <div class="faq-item">
                                    <?php if(!empty($assessmentCategory)){
                                            $i=1;foreach($assessmentCategory as $key=>$category){?>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <a data-toggle="collapse" href="#faq<?php echo $i;?>" class="faq-question">
                                               <?php echo $i.". ".$key;?></a>
                                        </div>
                                        <div class="col-md-3">
<!--                                            <span class="small font-bold">Robert Nowak</span>
                                            <div class="tag-list">
                                                <span class="tag-item">General</span>
                                                <span class="tag-item">License</span>
                                            </div>-->
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <span class="small font-bold">Question </span><br/>
                                            <?php echo count($category);?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="faq<?php echo $i;?>" class="panel-collapse collapse">
                                                <div class="faq-answer">
                                                   <div class="row">
                                                       <?php $j=1;foreach($category as $question){?>
                                                        <div class="col-md-12">
                                                             <div class='col-md-8'>
                                                            <a data-toggle="collapse" href="javascript:void(0)" class="text-success text-navy">
                                                            <?php echo $j.". ".$question['question'];?></a>
                                                            </div>
                                                            <div class='col-md-8'>
                                                                <?php $options = commonGetHelper($option=array('table'=>'questions_option','where'=> array('question_id' =>$question['question_id'])));?>
                                                                <?php $k=1;if(!empty($options)){foreach($options as $opt){?>    
                                                                <h5><?php echo $k.". ".$opt->label_option;?> (<?php echo $opt->point;?>) 
                                                                    <?php 
                                                                    if($question['assessment_type'] == 180){
                                                                     $ok = commonGetHelper($option=array('table'=>'assessment_submission','where'=> array('question_id' =>$question['question_id'],'user_assessment_id' =>$assessmentId,'select_option_id' => $opt->id)));
                                                                    }else{
                                                                        
                                                                    }
                                                                    ?>
                                                                    <?php if(!empty($ok)){?>
                                                                    <span class="text-success"><i class="fa fa-check"></i></span>
                                                                    <?php }?>
                                                                </h5>
                                                                <?php $k++;}}?>
                                                            </div>
                                                        </div>
                                                       <?php $j++;}?>
                                                </div>        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++;}}?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="form-modal-box"></div>
            </div>
        </div>
    </div>
