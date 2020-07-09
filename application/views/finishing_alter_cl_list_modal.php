<table class="table">
    <thead>
        <tr>
            <th class="center" colspan="3"><h4><b>Un-Scanned Identities</b></h4></th>
        </tr>
        <tr>
            <th class="center">PO: <?php echo $remain_size_cl[0]['purchase_order'];?></th>
            <th class="center">Style: <?php echo $remain_size_cl[0]['style_no'];?></th>
            <th class="center">Item: <?php echo $remain_size_cl[0]['item'];?></th>
        </tr>
        <tr>
            <th class="center">Style Name: <?php echo $remain_size_cl[0]['style_name'];?></th>
            <th class="center">QLT: <?php echo $remain_size_cl[0]['quality'];?></th>
            <th class="center">CLR: <?php echo $remain_size_cl[0]['color'];?></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Identity Label</th>
            <th class="center">Line</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($remain_size_cl as $v){ ?>
        <tr class="warning">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['pc_tracking_no'];?></td>
            <td class="center"><?php echo $v['line_code'];?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>