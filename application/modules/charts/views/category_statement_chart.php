<div class="clearfix"></div>
<hr>
<div class="col-md-12"><h4 class="text-info"><?php echo $category_name; ?></h4></div>
<table class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
            <th>Scoring Statement</th>
            <th>Self</th>
            <th>Leader</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($statement)) {
            foreach ($statement as $key => $statement) { ?>
                <tr class="gradeX">
                    <td class="center"><?php echo $statement; ?></td>
                    <td class="center"><?php echo (isset($self[$key]) && !empty($self[$key])) ? $self[$key] : '0'; ?></td>
                    <td class="center"><?php echo (isset($leader[$key]) && !empty($leader[$key])) ? $leader[$key] : '0'; ?></td>
                </tr>
    <?php }
} ?>
    </tbody>
</table>

