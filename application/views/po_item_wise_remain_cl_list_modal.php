<table class="table">
    <thead>
        <tr>
            <th class="center" colspan="4"><h4><b>Un-Scanned Identities</b></h4></th>
        </tr>
        <tr>
            <th class="center">PO: <?php echo $remain_size_cl[0]['purchase_order'];?></th>
            <th class="center">ITEM: <?php echo $remain_size_cl[0]['item'];?></th>
            <th class="center">Style: <?php echo $remain_size_cl[0]['style_no'];?></th>
            <th class="center">Style Name: <?php echo $remain_size_cl[0]['style_name'];?></th>
        </tr>
        <tr>
            <th class="center">QLT: <?php echo $remain_size_cl[0]['quality'];?></th>
            <th class="center">CLR: <?php echo $remain_size_cl[0]['color'];?></th>
            <th class="center" colspan="2"></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Cut</th>
            <th class="center">Bundle</th>
            <th class="center">Identity Label</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($remain_size_cl as $v){ ?>
        <tr class="warning">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['cut_no'];?></td>
            <td class="center"><?php echo $v['bundle_no'];?></td>
            <td class="center"><?php echo $v['pc_tracking_no'];?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>