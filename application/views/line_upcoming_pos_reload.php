<div class="left" style="width: 100%; font-size: 25px;"><b>Upcoming POs</b></div>
<br />
<marquee behavior="scroll" Scrolldelay="200" direction="up" scrollamount="1" onmouseover="this.stop();"
         onmouseout="this.start();" style="font-size: 18px; height: 75px;">

    <?php

    foreach ($upcoming_po as $v_3){ ?>

        <table border="1" style="margin-left: 25px;">
            <thead>
            <tr style="background-color: #f7ffb0;">
                <th class="center">PO_ITEM</th>
                <th class="center">Brand</th>
                <th class="center">QLTY_CLR</th>
                <th class="center">STYLE</th>
                <th class="center">QTY</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td class="center"><?php echo $v_3['purchase_order'].'_'.$v_3['item'];?></td>
                <td class="center"><?php echo $v_3['brand'];?></td>
                <td class="center"><?php echo $v_3['quality'].'_'.$v_3['color'];?></td>
                <td class="center"><?php echo $v_3['style_name'];?></td>
                <td class="center"><?php echo $v_3['total_order_qty'];?></td>
            </tr>

            </tbody>
        </table>
        <br />
    <?php } ?>

</marquee>