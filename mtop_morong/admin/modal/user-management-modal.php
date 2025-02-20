<div class="modal fade modal-central" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="centermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">User Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                      <div class="register-box" style="width: 100%">
                        <div class="register-logo">
                          <b>User</b>Management
                        </div>
        
                        <div class="card">
                          <div class="card-body register-card-body">
                            <p class="login-box-msg">Register a new membership</p>
        
                            <form action="#" method="post" id="user-form">
                              <div class="input-group mb-3">
                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full name">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                  </div>
                                </div>
                              </div>
                              <div class="input-group mb-3">
                                <input type="text" name="position" id="position" class="form-control" placeholder="Position">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-chess-rook"></span>
                                  </div>
                                </div>
                              </div>
        
                              <div class="input-group mb-3">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user-tie"></span>
                                  </div>
                                </div>
                              </div>
        
                              <div class="input-group mb-3" id="ipt-password">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                  </div>
                                </div>
                              </div>
        
                              <div class="input-group mb-3" id="ipt-retype">
                                <input type="password" name="retype" id="retype" class="form-control" placeholder="Retype password">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <!-- /.form-box -->
                        </div><!-- /.card -->
                      </div>
                  </div>
                  <div class='col-md-6'>
                      <div class="row">
                        <div class="col-6 col-sm-4">
                          <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="vert-tfarn-tab" data-toggle="pill" href="#vert-tabs-tfran" role="tab" aria-controls="vert-tabs-tfran" aria-selected="true">Tricycle Franchise</a>
                            <a class="nav-link" id="vert-cm-tab" data-toggle="pill" href="#vert-tabs-cm" role="tab" aria-controls="vert-tabs-cm" aria-selected="false">Change Motor</a>
                            <a class="nav-link" id="vert-co-tab" data-toggle="pill" href="#vert-tabs-co" role="tab" aria-controls="vert-tabs-co" aria-selected="false">Change Ownership</a>
                            <a class="nav-link" id="vert-drop-tab" data-toggle="pill" href="#vert-tabs-drop" role="tab" aria-controls="vert-tabs-drop" aria-selected="false">Dropping</a>
                            <a class="nav-link" id="vert-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Settings</a>
                            <a class="nav-link" id="vert-references-tab" data-toggle="pill" href="#vert-tabs-references" role="tab" aria-controls="vert-tabs-references" aria-selected="false">References</a>
                            <a class="nav-link" id="vert-report-tab" data-toggle="pill" href="#vert-tabs-report" role="tab" aria-controls="vert-tabs-report" aria-selected="false">Report</a>
                          </div>
                        </div>
                        <div class="col-6 col-sm-8">
                          <div class="tab-content" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade show active" id="vert-tabs-tfran" role="tabpanel" aria-labelledby="vert-tabs-tfran">
                                 <div class="form-group row">
                                    <label for="tfran-application" class="col-sm-4 col-form-label">Application</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-application-switch" id="tfran-application-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-application-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-view" class="col-sm-4 col-form-label">View</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-view-switch" id="tfran-view-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-view-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-inspection" class="col-sm-4 col-form-label">Inspection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-inspection-switch" id="tfran-inspection-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-inspection-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-assessment" class="col-sm-4 col-form-label">Assessment</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-assessment-switch" id="tfran-assessment-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-assessment-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-release" class="col-sm-4 col-form-label">Releasing</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-release-switch" id="tfran-release-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-release-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-cancel" class="col-sm-4 col-form-label">Cancel</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-cancel-switch" id="tfran-cancel-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-cancel-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-orencode" class="col-sm-4 col-form-label">OR Encode</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-orencode-switch" id="tfran-orencode-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-orencode-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tfran-appform" class="col-sm-4 col-form-label">Application Form</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input tfran-switch" name="tfran-appform-switch" id="tfran-appform-switch" checked="true">
                                        <label class="custom-control-label" for="tfran-appform-switch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-cm" role="tabpanel" aria-labelledby="vert-tabs-cm">
                               <div class="form-group row">
                                    <label for="cm-application" class="col-sm-4 col-form-label">Application</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-application-switch" id="cm-application-switch" checked="true">
                                        <label class="custom-control-label" for="cm-application-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-view" class="col-sm-4 col-form-label">View</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-view-switch" id="cm-view-switch" checked="true">
                                        <label class="custom-control-label" for="cm-view-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-inspection" class="col-sm-4 col-form-label">Inspection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-inspection-switch" id="cm-inspection-switch" checked="true">
                                        <label class="custom-control-label" for="cm-inspection-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-assessment" class="col-sm-4 col-form-label">Assessment</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-assessment-switch" id="cm-assessment-switch" checked="true">
                                        <label class="custom-control-label" for="cm-assessment-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-release" class="col-sm-4 col-form-label">Releasing</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-release-switch" id="cm-release-switch" checked="true">
                                        <label class="custom-control-label" for="cm-release-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-cancel" class="col-sm-4 col-form-label">Cancel</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-cancel-switch" id="cm-cancel-switch" checked="true">
                                        <label class="custom-control-label" for="cm-cancel-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-orencode" class="col-sm-4 col-form-label">OR Encode</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-orencode-switch" id="cm-orencode-switch" checked="true">
                                        <label class="custom-control-label" for="cm-orencode-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cm-appform" class="col-sm-4 col-form-label">Application Form</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input cm-switch" name="cm-appform-switch" id="cm-appform-switch" checked="true">
                                        <label class="custom-control-label" for="cm-appform-switch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-co" role="tabpanel" aria-labelledby="vert-tabs-co">
                                <div class="form-group row">
                                    <label for="co-application" class="col-sm-4 col-form-label">Application</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-application-switch" id="co-application-switch" checked="true">
                                        <label class="custom-control-label" for="co-application-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-view" class="col-sm-4 col-form-label">View</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-view-switch" id="co-view-switch" checked="true">
                                        <label class="custom-control-label" for="co-view-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-inspection" class="col-sm-4 col-form-label">Inspection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-inspection-switch" id="co-inspection-switch" checked="true">
                                        <label class="custom-control-label" for="co-inspection-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-assessment" class="col-sm-4 col-form-label">Assessment</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-assessment-switch" id="co-assessment-switch" checked="true">
                                        <label class="custom-control-label" for="co-assessment-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-release" class="col-sm-4 col-form-label">Releasing</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-release-switch" id="co-release-switch" checked="true">
                                        <label class="custom-control-label" for="co-release-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-cancel" class="col-sm-4 col-form-label">Cancel</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-cancel-switch" id="co-cancel-switch" checked="true">
                                        <label class="custom-control-label" for="co-cancel-switch"></label>
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <label for="co-orencode" class="col-sm-4 col-form-label">OR Encode</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-orencode-switch" id="co-orencode-switch" checked="true">
                                        <label class="custom-control-label" for="co-orencode-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="co-appform" class="col-sm-4 col-form-label">Application Form</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input co-switch" name="co-appform-switch" id="co-appform-switch" checked="true">
                                        <label class="custom-control-label" for="co-appform-switch"></label>
                                    </div>
                                </div>                        
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-drop" role="tabpanel" aria-labelledby="vert-tabs-drop">
                              <div class="form-group row">
                                    <label for="drop-application" class="col-sm-4 col-form-label">Application</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-application-switch" id="drop-application-switch" checked="true">
                                        <label class="custom-control-label" for="drop-application-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-view" class="col-sm-4 col-form-label">View</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-view-switch" id="drop-view-switch" checked="true">
                                        <label class="custom-control-label" for="drop-view-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-inspection" class="col-sm-4 col-form-label">Inspection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-inspection-switch" id="drop-inspection-switch" checked="true">
                                        <label class="custom-control-label" for="drop-inspection-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-assessment" class="col-sm-4 col-form-label">Assessment</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-assessment-switch" id="drop-assessment-switch" checked="true">
                                        <label class="custom-control-label" for="drop-assessment-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-release" class="col-sm-4 col-form-label">Releasing</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-release-switch" id="drop-release-switch" checked="true">
                                        <label class="custom-control-label" for="drop-release-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-cancel" class="col-sm-4 col-form-label">Cancel</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-cancel-switch" id="drop-cancel-switch" checked="true">
                                        <label class="custom-control-label" for="drop-cancel-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-orencode" class="col-sm-4 col-form-label">OR Encode</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-orencode-switch" id="drop-orencode-switch" checked="true">
                                        <label class="custom-control-label" for="drop-orencode-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="drop-appform" class="col-sm-4 col-form-label">Application Form</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input drop-switch" name="drop-appform-switch" id="drop-appform-switch" checked="true">
                                        <label class="custom-control-label" for="drop-appform-switch"></label>
                                    </div>
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings">
                              <div class="form-group row">
                                    <label for="settings-operator" class="col-sm-4 col-form-label">Operator</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input settings-switch" name="settings-operator-switch" id="settings-operator-switch" checked="true">
                                        <label class="custom-control-label" for="settings-operator-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="settings-motor" class="col-sm-4 col-form-label">Motor</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input settings-switch" name="settings-motor-switch" id="settings-motor-switch" checked="true">
                                        <label class="custom-control-label" for="settings-motor-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="settings-toda" class="col-sm-4 col-form-label">TODA</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input settings-switch" name="settings-toda-switch" id="settings-toda-switch" checked="true">
                                        <label class="custom-control-label" for="settings-toda-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="settings-frantoda" class="col-sm-6 col-form-label">Franchise per TODA</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input settings-switch" name="settings-frantoda-switch" id="settings-frantoda-switch" checked="true">
                                        <label class="custom-control-label" for="settings-frantoda-switch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-references" role="tabpanel" aria-labelledby="vert-tabs-references">
                              <div class="form-group row">
                                    <label for="references-requirements" class="col-sm-4 col-form-label">Requirements</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input references-switch" name="references-requirements-switch" id="references-requirements-switch" checked="true">
                                        <label class="custom-control-label" for="references-requirements-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="references-assfee" class="col-sm-5 col-form-label">Assessment Fees</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input references-switch" name="references-assfee-switch" id="references-assfee-switch" checked="true">
                                        <label class="custom-control-label" for="references-assfee-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="references-signa" class="col-sm-4 col-form-label">Signatories</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input references-switch" name="references-signa-switch" id="references-signa-switch" checked="true">
                                        <label class="custom-control-label" for="references-signa-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="references-make" class="col-sm-4 col-form-label">Make</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input references-switch" name="references-make-switch" id="references-make-switch" checked="true">
                                        <label class="custom-control-label" for="references-make-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="references-lto" class="col-sm-4 col-form-label">LTO Branches</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input references-switch" name="references-lto-switch" id="references-lto-switch" checked="true">
                                        <label class="custom-control-label" for="references-lto-switch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="vert-tabs-report" role="tabpanel" aria-labelledby="vert-tabs-report">
                              <div class="form-group row">
                                    <label for="report-franchise" class="col-sm-7 col-form-label">Masterlist New/Renew</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-franchise-switch" id="report-franchise-switch" checked="true">
                                        <label class="custom-control-label" for="report-franchise-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-cm" class="col-sm-7 col-form-label">Masterlist Change Motor</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-cm-switch" id="report-cm-switch" checked="true">
                                        <label class="custom-control-label" for="report-cm-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-co" class="col-sm-7 col-form-label">Masterlist Change Ownership</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-co-switch" id="report-co-switch" checked="true">
                                        <label class="custom-control-label" for="report-co-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-drop" class="col-sm-7 col-form-label">Masterlist Dropping</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-drop-switch" id="report-drop-switch" checked="true">
                                        <label class="custom-control-label" for="report-drop-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-exprdfran" class="col-sm-7 col-form-label">Expired Franchise</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-exprdfran-switch" id="report-exprdfran-switch" checked="true">
                                        <label class="custom-control-label" for="report-exprdfran-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-collection" class="col-sm-7 col-form-label">Collection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-collection-switch" id="report-collection-switch" checked="true">
                                        <label class="custom-control-label" for="report-collection-switch"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="report-abstract" class="col-sm-7 col-form-label">Abstract Collection</label>
                                     <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1" style="padding-top: 6px">
                                        <input type="checkbox" class="custom-control-input report-switch" name="report-abstract-switch" id="report-abstract-switch" checked="true">
                                        <label class="custom-control-label" for="report-abstract-switch"></label>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

