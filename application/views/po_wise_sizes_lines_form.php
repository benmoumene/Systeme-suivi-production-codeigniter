<div class="col-lg-6">
    <section class="panel default blue_title h2">
    <form action="<?php echo base_url();?>access/assignLineFromCutting" method="post">
        <div class="panel-body">
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="purchase_order" name="purchase_order" value="<?php echo $po_no;?>" readonly required />
                                <span style="font-size: 11px;">* PO No.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="item" name="item" value="<?php echo $item_week;?>" readonly required />
                                <span style="font-size: 11px;">* Item No.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="color" name="color" value="<?php echo $color;?>" readonly required />
                                <span style="font-size: 11px;">* Color</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr style="background-color: #baffe0;">
                        <th class="center">
                            Size
                        </th>
                        <th class="center">
                            Quantity
                        </th>
                        <th class="center">
                            <select name="line_all" id="line_all" onchange="selectLinesAuto(id);">
                                <option value="">Select Line...</option>
                            <?php
                                foreach ($lines_floors as $v_l){ ?>
                                    <option value="<?php echo $v_l['id']?>"><?php echo $v_l['line_name']?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </th>
                        <th class="center">
                            Assigned Line#
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($order_info as $v){ ?>
                    <tr>
                        <td class="center">
                            <?php echo $v['size'];?>
                            <input type="hidden" id="size" name="size[]" value="<?php echo $v['size'];?>" readonly required />
                        </td>
                        <td class="center">
                            <?php echo $v['qty'];?>
                        </td>
                        <td class="center">
                            <select class="line" name="line[]" id="line">
                                <option value="">Select Line...</option>
                                <?php
                                foreach ($lines_floors as $vl){ ?>
                                    <option value="<?php echo $vl['id']?>"><?php echo $vl['line_name']?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td class="center">
                            <?php echo $v['line_name'];?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </section>
</div>

<script type="text/javascript">
    $('select').select2();

    function selectLinesAuto(id) {
        var line_id = $("#"+id).val();
console.log(line_id);
//        document.getElementsByClassName("line").value = line_id;
        $('.line').each(function() {
            this.value = line_id;
        });
    }
</script>