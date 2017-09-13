<hr>
<table class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
            <th>Scoring Category</th>
            <th>Self</th>
            <th>Leader</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($category)) {
            foreach ($category as $cat) { ?>
                <tr class="gradeX">
                    <td class="center"><a href='javascript:void(0)' onclick="caregoryStatementChart('<?php echo $cat->cat_id; ?>', '<?php echo $userId; ?>')"><?php echo $cat->category_name ?></a></td>
                    <td class="center"><?php echo (isset($self[$cat->cat_id]) && !empty($self[$cat->cat_id])) ? $self[$cat->cat_id]->avg_point : '0'; ?></td>
                    <td class="center"><?php echo (isset($leader[$cat->cat_id]) && !empty($leader[$cat->cat_id])) ? $leader[$cat->cat_id]->avg_point : '0'; ?></td>
                </tr>
    <?php }
} ?>
    </tbody>
</table>
<div class="clearfix"></div>
<hr>