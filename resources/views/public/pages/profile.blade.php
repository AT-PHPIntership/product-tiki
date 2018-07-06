@extends('public.layout.master')
@section('title', __('user/profile.title'))
@section('css')
  <link href="/css/public/profile.css" rel="stylesheet">
@endsection
@section('content')
<div class="top-brands">
  <div class="container">
        <div class="col-md-12">
          <div class="page-title">
            <div class="title_left">
              <h3>{{ __('user/profile.title') }}</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel col-md-12">
                <div class="x_title col-md-12">
                  <h2>{{ __('user/profile.subtitle') }}</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content col-md-12">
                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="" alt="Avatar" title="Change the avatar">
                      </div>
                    </div>

                    <ul class="list-unstyled user_data">
                      <li id="user_data_username" class="m-top-xs">
                        <i class="fa fa-user"></i>
                        <a></a>
                      </li>
                      <li id="user_data_gender" class="m-top-xs">
                        <a></a>
                      </li>
                      <li id="user_data_address" class="m-top-xs">
                        <i class="fa fa-map-marker user-profile-icon"></i>
                        <a></a>
                      </li>
                      <li id="user_data_email" class="m-top-xs">
                        <i class="fa fa-envelope user-profile-icon"></i>
                        <a></a>
                      </li>
                    </ul>
                    <br>
                    <a class="btn btn-success" data-toggle="modal" data-target="#edit_profile"><i class="fa fa-edit m-right-xs"></i>{{ __('user/profile.edit_profile') }}</a>
                    <br />

                    <div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('user/register.form.information') }}</h4>
                          </div>
                          <div class="modal-body">

                              <form id="demo-form2" method="POST" class="form-horizontal form-label-left" enctype:'multipart/form-data'>
                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">{{ __('user.index.fullname') }}<span class="required">{{ __('user.index.requied') }}</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="full_name" name="full_name" class="form-control col-md-7 col-xs-12">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="full_name_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">{{ __('user.index.address') }}<span class="required">{{ __('user.index.requied') }}</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="address" name="address" class="form-control col-md-7 col-xs-12">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="address_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">{{ __('user.index.phone') }}<span class="required">{{ __('user.index.requied') }}</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="phone_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity_card">{{ __('user.index.indentity_card') }}<span class="required">{{ __('user.index.requied') }}</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="identity_card" name="identity_card" class="form-control col-md-7 col-xs-12">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="identity_card_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="avatar">{{ __('user.index.avatar') }}</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" id="avatar" name="avatar" class="form-control col-md-7 col-xs-12">
                                    <img id="img_avatar" class="avatar-view" src="" alt="">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="avatar_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.gender') }}</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="btn btn-info" id="gender" name="gender">
                                    <option value="">{{ __('user/register.form.gender_default') }}</option>
                                    <option value="0">{{ __('user/register.form.gender_male') }}</option>
                                    <option value="1">{{ __('user/register.form.gender_female') }}</option>
                                  </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="gender_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('user.index.dob') }}</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="dob" name="dob" class="form-control col-md-7 col-xs-12" type="date">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <div id="dob_error" class="alert alert-danger" hidden></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="submit" id="edit_profile_submit" class="btn btn-success" value="{{ __('user.index.update') }}">
                                  </div>
                                </div>
                              </form>

                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="note_cancel_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
                      <div class="modal-dialog note-cancel-order" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4>@lang('user/profile.note_cancel_order')</h4>
                          </div>
                          <div class="modal-body">

                              <form id="demo-form2" method="POST" class="form-horizontal form-label-left">
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-6 col-xs-12">
                                    <textarea rows="5" id="note" name="note" class="form-control col-md-7 col-xs-12"></textarea>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                                    <input type="submit" id="note_cancel_order_submit" class="btn btn-success" value="{{ __('category.admin.add.submit') }}">
                                  </div>
                                </div>
                              </form>

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="row" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs-bar bar_tabs" role="tablist">
                        <li role="presentation" class="col-md-3"><a href="#user_profile" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">{{ __('user/profile.user_profile') }}</a>
                        </li>
                        <li role="presentation" class="col-md-3"><a href="#recent_activity" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">{{ __('user/profile.recent_activity') }}</a>
                        </li>
                        <li role="presentation" class="col-md-3"><a href="#recent_order" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">{{ __('user/profile.recent_order') }}</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="user_profile" aria-labelledby="profile-tab">

                          <!-- start user projects -->
                          <ul class="user-info">
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.username_col') }}</h4>
                                <blockquote id="username" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.email_col') }}</h4>
                                <blockquote id="email" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.fullname_col') }}</h4>
                                <blockquote id="full_name" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.address_col') }}</h4>
                                <blockquote id="address" class="message"></blockquote>
                                <a id="btn-show-address" class="btn btn-success" data-toggle="modal" data-target="#show-address">{{ __('user/profile.view_address_list') }}</a>
                                <br />
                              </div>
                            </li>

                            <div class="modal fade" id="show-address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" hidden>
                              <div class="modal-dialog" role="document">
                                <div class="modal-content row">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ __('orders.admin.show.list_note') }}</h4>
                                  </div>
                                  <div class="modal-body col-md-10 col-md-offset-1">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th class="center-col col-md-8">{{ __('user/profile.address') }}</th>
                                          <th class="center-col col-md-4">{{ __('user/profile.profile_action') }}</th>
                                        </tr>
                                      </thead>
                                      <tbody >
                                        <tr id='template-address' style="display: none">
                                          <td><span class="address"></span></td>
                                          <td><button type="button" class = "btn btn-warning btn-address">{{ __('user/profile.edit_address') }}</button></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.gender_col') }}</h4>
                                <blockquote id="gender" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.dob_col') }}</h4>
                                <blockquote id="dob" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.phone_col') }}</h4>
                                <blockquote id="phone" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                            <li>
                              <div class="message_wrapper">
                                <h4 class="heading">{{ __('user/profile.id_col') }}</h4>
                                <blockquote id="identity_card" class="message"></blockquote>
                                <br />
                              </div>
                            </li>
                          </ul>
                          <!-- end user projects -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="recent_activity" aria-labelledby="profile-tab">
                          <div id="table-content">
                          <table class="table-post data table table-striped no-margin">
                            <thead>
                                <tr>
                                    <th class="col-md-10">{{ __('user/profile.profile_content') }}</th>
                                    <th class="col-md-3">{{ __('user/profile.profile_product') }}</th>
                                    <th class="col-md-2">{{ __('user/profile.profile_status') }}</th>
                                    <th class="col-md-2">{{ __('user/profile.profile_type') }}</th>
                                    <th class="col-md-2">{{ __('user/profile.profile_button_comment') }}</th>
                                </tr>
                            </thead>
                          <tbody>
                            <tr id="template-post" style="display:none;">
                              <td class="content col-md-10"></td>
                              <td class="prduct-name col-md-3"></td>
                              <td class="status col-md-2"></td>
                              <td class="type col-md-2"></td>
                              <td class="subcomment col-md-2"></td>

                              <table id="replies" hidden class="table-subcomment col-md-offset-3 data table table-striped no-margin">
                                <thead>
                                  <tr>
                                    <th class="col-md-10">{{ __('user/profile.replies_content_subcm') }}</th>
                                    <th class="col-md-3">{{ __('user/profile.fullname_subcm') }}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="replies-content"></td>
                                    <td class="replies-fullname"></td>
                                  </tr>
                                </tbody>
                              </table>

                            </tr>
                          </tbody>
                        </table>
                          </div>
                          <nav class="paginate-profile">
                            <a id="next" hidden href="">{{ __('user/profile.next') }}</a>
                          </nav>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="recent_order" aria-labelledby="profile-tab">
                          <!-- start user projects -->
                          <div id='no-record' hidden>{{ __('user/profile.profile_non_order') }}</div>
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th class="col-md-7">{{ __('user/profile.profile_order_note') }}</th>
                                <th class="col-md-2">{{ __('user/profile.profile_total') }}</th>
                                <th class="col-md-2">{{ __('user/profile.profile_status') }}</th>
                                <th class="col-md-5">{{ __('user/profile.profile_action') }}</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                          <nav class="paginate-profile">
                            <a id="next" hidden="" href="">{{ __('user/profile.next') }}</a>
                          </nav>
                          <div id="order_detail" hidden>
                            <form action="" method="post" class="form-horizontal form-label-left">

                            </form>
                          </div>
                          <!-- end user projects -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
@endsection
@section('js')
<script src="/js/public/profile.js"></script>
<script src="/js/public/userProfile.js"></script>
<script src="/js/public/userposts.js"></script>
<script src="/js/public/userOrder.js"></script>
@endsection
