<?php
//site setting helper function
$getSiteSetting = getSiteSetting();
$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}
//default base color
$base_color = "#6ab04c";
//dynamic db base color
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
?>

<?php
if ($this->session->flashdata('exception_1')) {

  echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
  echo escape_output($this->session->flashdata('exception_1'));
  echo '</p></div></section>';
}
?>
<section class="content-header">
  <h1>
    <?php echo lang('site_setting'); ?>
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">

    <!-- left column -->
    <div class="col-md-12">
      <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open(base_url() . 'Authentication/siteSetting', $arrayName = array('id' => 'add_whitelabel', 'enctype' => 'multipart/form-data')) ?>
        <div class="box-body">
          <input type="hidden" name="id" value="<?php echo (isset($getSiteSetting) && $getSiteSetting->id ? $getSiteSetting->id : '') ?>">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('site_title'); ?> <span class="required_star">*</span></label>
                <input type="text" tabindex="1" name="site_title" class="form-control" id="site_title" value="<?php echo isset($getSiteSetting) && $getSiteSetting->site_title ? $getSiteSetting->site_title : set_value('site_title'); ?>" />

              </div>
              <?php if (form_error('site_title')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('site_title'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('footer'); ?> <span class="required_star">*</span></label>
                <input type="text" tabindex="2" name="footer" class="form-control" id="footer" placeholder="<?php echo lang('footer'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->footer ? $getSiteSetting->footer : set_value('footer'); ?>" />
              </div>
              <?php if (form_error('footer')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('footer'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('base_color'); ?> <span class="required_star">*</span></label>
                <input type="text" tabindex="3" name="base_color" class="form-control getColor" id="base_color" placeholder="<?php echo lang('base_color'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->base_color ? $getSiteSetting->base_color : set_value('base_color'); ?>" />
              </div>
              <?php if (form_error('base_color')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('base_color'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                <input type="text" name="phone" tabindex="4" class="form-control" id="phone" placeholder="<?php echo lang('phone'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->phone ? $getSiteSetting->phone : set_value('phone'); ?>" />
              </div>
              <?php if (form_error('phone')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('phone'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('email'); ?> <span class="required_star">*</span></label>
                <input type="text" name="email" tabindex="5" class="form-control" id="email" placeholder="<?php echo lang('email'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->email ? $getSiteSetting->email : set_value('email'); ?>" />
              </div>
              <?php if (form_error('email')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('email'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('address'); ?> <span class="required_star">*</span></label>
                <textarea type="text" name="address" tabindex="6" class="form-control" id="address" placeholder="<?php echo lang('address'); ?>"><?php echo isset($getSiteSetting) && $getSiteSetting->address ? $getSiteSetting->address : set_value('address'); ?></textarea>
              </div>
              <?php if (form_error('address')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('address'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">

              <div class="form-group">
                <label> <?php echo lang('date_format'); ?> <span class="required_star">*</span></label>
                <select tabindex="2" class="form-control select2 width_100_p" name="date_format" id="date_format">
                  <option value=""><?php echo lang('select'); ?></option>
                  <option <?php echo isset($getSiteSetting) && $getSiteSetting->date_format == "d/m/Y" ? 'selected' : '' ?> value="d/m/Y">
                    D/M/Y
                  </option>
                  <option <?php echo isset($getSiteSetting) && $getSiteSetting->date_format == "m/d/Y" ? 'selected' : '' ?> value="m/d/Y">
                    M/D/Y
                  </option>
                  <option <?php echo isset($getSiteSetting) && $getSiteSetting->date_format == "Y/m/d" ? 'selected' : '' ?> value="Y/m/d">
                    Y/M/D
                  </option>
                </select>
              </div>
              <?php if (form_error('date_format')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('date_format'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('currency'); ?> <span class="required_star">*</span></label>
                <select class="form-control select2 width_100_p" name="currency" id="currency">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php
                  foreach ($currencies as $value) :
                  ?>
                    <option <?php echo isset($getSiteSetting->currency) && $getSiteSetting->currency && $getSiteSetting->currency == $value->symbol ? 'selected' : '' ?> value="<?php echo escape_output($value->symbol); ?>"><?php echo escape_output($value->country); ?>
                      (<?php echo escape_output($value->symbol); ?>)
                    </option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
              <?php if (form_error('currency')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('currency'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('country_time_zone'); ?> <span class="required_star">*</span></label>
                <select class="form-control select2 width_100_p" name="time_zone" id="time_zone">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php
                  foreach ($time_zones as $value) :
                  ?>
                    <option <?php echo isset($getSiteSetting->time_zone) && $getSiteSetting->time_zone && $getSiteSetting->time_zone == $value->zone_name ? 'selected' : '' ?> value="<?php echo escape_output($value->zone_name); ?>"><?php echo escape_output($value->zone_name); ?></option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
              <?php if (form_error('time_zone')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('time_zone'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
              <div class="form-group">
                <?php
                $stt = sizeof(json_decode($getSiteSetting->site_languages));
                ?>
                <input type="hidden" value="<?php echo isset($stt) && $stt ? $stt : '' ?>" id="site_languages_h" name="site_languages_h">
                <label><?php echo lang('AvailableLanguageforFrontend'); ?> <span class="required_star">*</span> </label>

                <select class="form-control select_multiple" name="site_languages[]" id="site_languages">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php
                  $dir = glob("application/language/*", GLOB_ONLYDIR);
                  foreach ($dir as $value) :
                    $separete = explode("language/", $value);
                  ?>
                    <option class="get_lg" data-text="<?php echo ucfirst($separete[1]) ?>" value="<?php echo escape_output($separete[1]) ?>"><?php echo ucfirst($separete[1]) ?></option>

                  <?php
                  endforeach;
                  ?>
                </select>
                <?php if (form_error('site_languages_h')) { ?>
                  <div class="alert alert-error txt-uh-21">
                    <p><?php echo form_error('site_languages_h'); ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('defaultLanguageforFrontend'); ?> <span class="required_star">*</span></label>

                <select class="form-control select2" name="default_language_frontend">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php
                  $dir = glob("application/language/*", GLOB_ONLYDIR);
                  foreach ($dir as $value) :
                    $separete = explode("language/", $value);
                  ?>
                    <option <?php echo isset($getSiteSetting->default_language_frontend) && $getSiteSetting->default_language_frontend && $getSiteSetting->default_language_frontend == escape_output($separete[1]) ? 'selected' : '' ?> value="<?php echo escape_output($separete[1]) ?>"><?php echo ucfirst($separete[1]) ?></option>

                  <?php
                  endforeach;
                  ?>
                </select>
                <?php if (form_error('default_language_frontend')) { ?>
                  <div class="alert alert-error txt-uh-21">
                    <p><?php echo form_error('default_language_frontend'); ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('Product Hover Effect'); ?> <span class="required_star">*</span></label>
                <select class="form-control select2 width_100_p" name="product_hover_effect" id="product_hover_effect">
                  <option <?php echo isset($getSiteSetting->product_hover_effect) && $getSiteSetting->product_hover_effect && $getSiteSetting->product_hover_effect == "Yes" ? 'selected' : '' ?> value="Yes"><?php echo lang('yes'); ?></option>
                  <option <?php echo isset($getSiteSetting->product_hover_effect) && $getSiteSetting->product_hover_effect && $getSiteSetting->product_hover_effect == "No" ? 'selected' : '' ?> value="No"><?php echo lang('no'); ?></option>

                </select>
              </div>
              <?php if (form_error('product_hover_effect')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('product_hover_effect'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('FacebookLink1'); ?></label>
                <input type="text" name="facebook_link" class="form-control" id="facebook_link" placeholder="<?php echo lang('FacebookLink'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->facebook_link ? $getSiteSetting->facebook_link : set_value('facebook_link'); ?>" />

              </div>
              <?php if (form_error('facebook_link')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('facebook_link'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('TwitterLink1'); ?></label>
                <input type="text" name="twitter_link" class="form-control" id="twitter_link" placeholder="<?php echo lang('TwitterLink'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->twitter_link ? $getSiteSetting->twitter_link : set_value('twitter_link'); ?>" />

              </div>
              <?php if (form_error('twitter_link')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('twitter_link'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> <?php echo lang('PinterestLink1'); ?></label>
                <input type="text" name="pinterest_link" class="form-control" id="pinterest_link" placeholder="<?php echo lang('PinterestLink'); ?>" value="<?php echo isset($getSiteSetting) && $getSiteSetting->pinterest_link ? $getSiteSetting->pinterest_link : set_value('pinterest_link'); ?>" />

              </div>
              <?php if (form_error('pinterest_link')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('pinterest_link'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url() ?>slideshow/slideshows"><?php echo lang('slideshow'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/deliveryTimeRange"><?php echo lang('delivery_time_range'); ?> </a>
            </div>

            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/deliveryChargeSetup"><?php echo lang('delivery_charge_setup'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/smtpEmailSetting"><?php echo lang('SMTPEmailSetting'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/smsSetting"><?php echo lang('SMSSetting'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>page/pages"><?php echo lang('Pages'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>area/area"><?php echo lang('Area'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/paymentSetting"><?php echo lang('PaymentSetting'); ?> </a>
            </div>
            <div class="col-md-3">
              <label> <br></label>
              <a target="_blank" class="btn btn-block btn-primary" href="<?php echo base_url(); ?>authentication/dummyData"><?php echo lang('dummyData'); ?> </a>
            </div>

            <p>&nbsp;</p>
            <div class="clearfix"></div>
            <p>&nbsp;</p>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('site_logo'); ?> (Width: 230px, Height:50px, Max Size: 50kb) <span class="required_star">*</span></label>
                <a data-file_path="<?= base_url() ?>assets/images/<?= escape_output($getSiteSetting->site_logo); ?>" data-id="1" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->site_logo ? $getSiteSetting->site_logo : set_value('old_site_logo'); ?>" name="old_site_logo">
                <input type="file" accept="image/*" name="site_logo" class="form-control" id="site_logo" placeholder="<?php echo lang('site_logo'); ?>">
              </div>
              <?php if (form_error('site_logo')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('site_logo'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('login_page_bg'); ?> (Width: 1571px, Height:1102px, Max Size: 300kb) <span class="required_star">*</span></label> <a data-file_path="<?php echo base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->login_page_bg); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->login_page_bg ? $getSiteSetting->login_page_bg : set_value('old_login_page_bg'); ?>" name="old_login_page_bg">
                <input type="file" accept="image/*" name="login_page_bg" class="form-control" id="login_page_bg" placeholder="<?php echo lang('login_page_bg'); ?>">
              </div>
              <?php if (form_error('login_page_bg')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('login_page_bg'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('favicon'); ?>(File Type ico, Width: 16px, Height:16px, Max Size: 10kb) <span class="required_star">*</span></label><a data-file_path="<?php echo base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->favicon); ?>" data-id="3" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->favicon ? $getSiteSetting->favicon : set_value('old_favicon'); ?>" name="old_favicon">
                <input type="file" accept="image/*" name="favicon" class="form-control" id="favicon" placeholder="<?php echo lang('favicon'); ?>">
              </div>
              <?php if (form_error('favicon')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('favicon'); ?></p>
                </div>
              <?php } ?>
            </div>


            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> Frontend Offer Banner Image (Width: 390px, Height:160px, Max Size: 300kb)</label><a data-file_path="<?= base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->frontend_offer_banner_image); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->frontend_offer_banner_image ? $getSiteSetting->frontend_offer_banner_image : set_value('frontend_offer_banner_image'); ?>" name="frontend_offer_banner_image">
                <input type="file" accept="image/*" name="frontend_offer_banner_image" class="form-control" id="frontend_offer_banner_image" placeholder="<?php echo lang('frontend_offer_banner_image'); ?>">
              </div>
              <?php if (form_error('frontend_offer_banner_image')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('frontend_offer_banner_image'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> Frontend Offer Banner Image URL</label>
                <input type="text" name="frontend_offer_banner_url" class="form-control" id="frontend_offer_banner_url" value="<?= $getSiteSetting->frontend_offer_banner_url ?? set_value('frontend_offer_banner_url'); ?>" placeholder="Frontend Offer Banner URL">
              </div>
              <?php if (form_error('frontend_offer_banner_url')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('frontend_offer_banner_url'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('frontend_middle_image_1'); ?>(Width: 390px, Height:160px, Max Size: 300kb)</label><a data-file_path="<?php echo base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->frontend_middle_image_1); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->frontend_middle_image_1 ? $getSiteSetting->frontend_middle_image_1 : set_value('old_frontend_middle_image_1'); ?>" name="old_frontend_middle_image_1">
                <input type="file" accept="image/*" name="frontend_middle_image_1" class="form-control" id="frontend_middle_image_1" placeholder="<?php echo lang('frontend_middle_image_1'); ?>">
              </div>
              <?php if (form_error('frontend_middle_image_1')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('frontend_middle_image_1'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('frontend_middle_image_2'); ?>(Width: 390px, Height:160px, Max Size: 300kb)</label><a data-file_path="<?php echo base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->frontend_middle_image_2); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->frontend_middle_image_2 ? $getSiteSetting->frontend_middle_image_2 : set_value('old_frontend_middle_image_2'); ?>" name="old_frontend_middle_image_2">
                <input type="file" accept="image/*" name="frontend_middle_image_2" class="form-control" id="frontend_middle_image_2" placeholder="<?php echo lang('frontend_middle_image_2'); ?>">
              </div>
              <?php if (form_error('frontend_middle_image_2')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('frontend_middle_image_2'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('frontend_middle_image_3'); ?>(Width: 390px, Height:160px, Max Size: 300kb)</label><a data-file_path="<?php echo base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->frontend_middle_image_3); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="hidden" value="<?php echo isset($getSiteSetting) && $getSiteSetting->frontend_middle_image_3 ? $getSiteSetting->frontend_middle_image_3 : set_value('old_frontend_middle_image_3'); ?>" name="old_frontend_middle_image_3">
                <input type="file" accept="image/*" name="frontend_middle_image_3" class="form-control" id="frontend_middle_image_3" placeholder="<?php echo lang('frontend_middle_image_3'); ?>">
              </div>
              <?php if (form_error('frontend_middle_image_3')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('frontend_middle_image_3'); ?></p>
                </div>
              <?php } ?>
            </div>

          </div>
        </div>

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary submit_form"><?php echo lang('submit'); ?></button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="logo_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header txt-uh-25">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body txt-uh-26">
        <div class="row">
          <div class="col-md-12" style="background-color: <?php echo escape_output($base_color) ?>;text-align: center;padding: 10px;">
            <img src="" id="show_id">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="logo_preview_icon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header txt-uh-25">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body txt-uh-26">
        <div class="row">
          <div class="col-md-12 txt-uh-27">
            <img class="txt-uh-28" src="" id="logo_preview_icon_img">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>


<div class="modal fade" id="logo_preview_login_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header txt-uh-25">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body txt-uh-26">
        <div class="row">
          <div class="col-md-12 txt-uh-27">
            <img class="txt-uh-28" src="" id="show_id1">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>


<?php
$javascript_obects = "";
//site language json data and convert it as a decode
$tmp_va = json_decode($getSiteSetting->site_languages);
//total count of row
$total_languages = count($tmp_va);
$i = 1;
foreach ($tmp_va as $value) :
  if ($total_languages == $i) {
    $javascript_obects .= "{value:'" . $value->value . "'}";
  } else {
    $javascript_obects .= "{value:'" . $value->value . "'},";
  }
  $i++;
endforeach;


?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<script>
  //languages object
  //This variable could not be escaped because this is building object
  window.languages = [<?php echo $javascript_obects ?>];
</script>
<script src="<?php echo base_url() ?>assets/js/site_setting.js"></script>