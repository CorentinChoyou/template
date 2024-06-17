

<div id="admin">
    <?php if ( $is_logged_in_status ) { ?>
    <p>loged</p>
    <?php } else{ ?>
    <p>deco</p>
   <?php } ?>
<p>
</p>
</div>



<style>
    #admin {
        background-color: black;
        padding: 20px;
        text-align: center;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 50px;
        color: red;
    }
</style>