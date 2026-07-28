<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Message</h5>
        <p><?php echo $message->message;?>.</p>
        <h5 class="card-title mb-3">Subject</h5>
        <p><?php echo $message->subject;?>.</p>
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="d-flex mt-4">
                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                            <i class="ri-user-2-fill"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1">Name :</p>
                        <h6 class="text-truncate mb-0"><?php echo $message->name;?></h6>
                    </div>

                    
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex mt-4">
                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                            <i class="ri-mail-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1">From :</p>
                        <h6 class="text-truncate mb-0"><?php echo $message->email;?></h6>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-6 col-md-3">
                <div class="d-flex mt-4">
                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary shadow">
                            <i class="bx bx-calendar"></i><i class="ri-time-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1">Date & Time :</p>
                        <a href="#" class="fw-semibold"><?php echo date('d/m/Y h:i A', $message->timestamp);?></a>
                    </div>
                </div>
            </div>
            <?php if($message->reply==""){?>
            <div class="col-6 col-md-1">
				<div class="d-flex mt-4">
	            	<button class="btn btn-sm btn-outline-primary btn-border" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Reply</button>
            	</div>
            </div>
        	<?php } ?>
            <div class="col-6 col-md-1">
            	<div class="d-flex mt-4">
	            	<a href="<?php echo base_url('administrator/contact_message')?>" class="btn btn-sm btn-outline-danger btn-border">Go Back</a>
            	</div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end card-body-->
</div><!-- end card -->

<!-- staticBackdrop Modal -->
<div class="modal fade zoomIn" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        	<form action="<?php echo base_url('AdminController/saveReply/'.$message->contact_message_id);?>" method="post">
	            <div class="modal-body text-center p-5">
		            <div class="mb-4">
					    <h4>Reason</h4>
					    <textarea name="reply" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
						
	                </div>
	                    <div class="hstack gap-2 justify-content-center">
	                        <a href="javascript:void(0);" class="btn btn-link shadow-none link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
	                        <button type="submit" class="btn btn-success">Send</button>
	                </div>
	            </div>
        	</form>
        </div>
   	</div>
</div>
