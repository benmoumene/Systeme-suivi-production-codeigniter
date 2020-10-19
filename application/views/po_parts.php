<div class="col-md-6 tableFixHead">
    <table class="table table-bordered table-striped" id="" border="1">
        <thead>
            <tr>
                <th class="hidden-phone center">SL</th>
                <th class="hidden-phone center">Part Name</th>
                <th class="hidden-phone center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sl=1;

            foreach($parts AS $p){ ?>
                <tr>
                    <td class="hidden-phone center"><?php echo $sl; $sl++;?></td>
                    <td class="hidden-phone center"><?php echo $p['part_code'];?></td>
                    <td class="hidden-phone center">
                        <span class="btn btn-danger" onclick="deletePoPart(<?php echo $p['id'];?>);">X</span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>