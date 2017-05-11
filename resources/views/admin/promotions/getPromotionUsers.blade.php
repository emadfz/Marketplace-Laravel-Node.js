<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">PROMOTION USER(S)</h4>    
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <h4>User Name(s)</h4>
            <?php
            foreach ($users as $user) {
                ?>
                <p>
                    <span class="col-md-12 form-control"><?php echo  $user;?></span>
                </p>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>    
</div>
