<!-- Default modal Size -->
<div class="modal fade" id="user<?php echo $user->id; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="defaultModalLabel">Update <?php echo $user->name; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="status" style="margin:0 auto;"></span>

                <?php echo form_open_multipart(base_url('auth/updateUser'), array('id' => 'update_user', 'class' => 'update_user')); ?>


                <div class="col-md-12">
                    <strong style="margin-right: 1em;"> Name </strong>
                    <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control"
                        style="width:100%" required>
                        <br>

                    <strong style="margin-right: 1em;">Email </strong>
                    <input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control"
                        style="width:100%">
                        <br>

                    <strong style="margin-right: 1em;">User Group </strong>
                    <select name="role" style="width:100%;" class="form-control role select2" required>

                        <?php foreach ($usergroups as $usergroup) :
            ?>
                        <option value="<?php echo $usergroup->id; ?>" <?php if ($user->role == $usergroup->id) {
                                                              echo "selected";
                                                            } ?>><?php echo $usergroup->group_name; ?>

                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
               
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Organisation</label>
                        <input type="email" required name="email" class="form-control" placeholder="Email" required />


                    </div>
                </div>

                <br>
                <div class="col-md-12">
                <div class="form-group">
                    <label>Outbreak</label>
                    <select name="outbreak_id" style="width:100%;" class="role form-control select2" required>
                        <option value="" disabled selected>Select Outbreak</option>
                        <?php 
                $rows = $this->db->get('outbreak_events')->result();
                foreach ($rows as $row) :
                ?>
                        <option value="<?php echo $row->id; ?>"
                            <?php if ($user->outbreak_id==$row->id){ echo "selected";}?>>
                            <?php echo $row->outbreak_name; ?>

                        </option>
                        <?php endforeach; ?>
                    </select>


                    </select>


                </div>
                </div>
                <br><br>
                <input type="hidden" name="id" value="<?php echo $user->id; ?>">

                <button type="submit" data-toggle="modal" class="btn btn-info">Save Changes</button>


            </div>
            <div class="modal-footer">

            </div>
            </form>
        </div>
    </div>
</div>
</div>