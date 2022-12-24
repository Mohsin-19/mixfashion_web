<style>
    legend.panel-title.uk-legend {
        color: white;
        padding: 10px;
        margin: 0 5px;
    }
    label{
        width: 150px !important;
        display: inline-block;
        text-align: right;
    }
    .StripeElement {
        height: 40px;
        padding: 10px 12px;
        color: #32325d;
        background-color: white;
        border: 1px solid #e5e5e5;
        display: inline-block;
        vertical-align: middle;
    }

    input:focus,
    .StripeElement--focus {
        outline: 0;
        background-color: #fff;
        color: #666;
        border-color: #1e87f0;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    #paymentFrm{
        padding: 0 5px;
    }
    @media(max-width: 600px){
        label{
            display: block;
            text-align:left;
        }
    }

</style>

<fieldset class="panel uk-fieldset uk-text-center uk-margin-small-top">
    <div class="panel-heading">
        <legend class="panel-title uk-legend"><?php echo lang('Payment'); ?> <?php echo '$'.$total_payable_str; ?> <?php echo lang('withStripe'); ?></legend>
    </div>
    <div class="panel-body">
        <!-- Display errors returned by createToken -->
        <div class="card-errors"></div>
        <!-- Payment form -->
        <form action="<?php echo base_url()?>stripePayment" method="POST" id="paymentFrm">
            <input type="hidden" name="payable_amount" value="<?php echo escape_output($total_payable_str)?>">
            <input type="hidden" name="order_id_str" value="<?php echo escape_output($order_id_str)?>">
            <input type="hidden" name="description" value="<?php echo escape_output($description)?>">

            <div class="uk-margin uk-child-width-1-2@s">
                <label for="name"><?php echo lang('customer'); ?> <?php echo lang('name'); ?></label>
                <input type="text" class="uk-input" name="name" id="name" value="<?php echo escape_output($this->session->userdata('c_name')); ?>" class="field"
                    placeholder="Enter name" required="" autofocus="">
            </div>

            <div class="uk-margin uk-child-width-1-2@s">
                <label for="email"><?php echo lang('CustomerEmail'); ?></label>
                <input type="text" class="uk-input" name="email" id="email" value="<?php echo escape_output($this->session->userdata('c_email')); ?>"
                    class="field" placeholder="Enter email">
            </div>
            <div class="uk-margin uk-child-width-1-2@s">
                <label><?php echo lang('CardNumber'); ?></label>
                <div id="card_number" class="field"></div>
            </div>
            <div class="row">
                <div class="left">
                    <div class="uk-margin uk-child-width-1-2@s">
                        <label><?php echo lang('ExpiryDate'); ?></label>
                        <div id="card_expiry" class="field"></div>
                    </div>
                </div>
                <div class="right">
                    <div class="uk-margin uk-child-width-1-2@s">
                        <label><?php echo lang('CVCCode'); ?></label>
                        <div id="card_cvc" class="field"></div>
                    </div>
                </div>
            </div>
            <button type="submit" style="padding: 12px 35px;font-size: 16px;" class="c-btn bgAlphaColor" id="payBtn"><?php echo lang('ConfirmAgain'); ?></button>
        </form>
    </div>
</fieldset>
<?php
//for demo mode
if(APPLICATION_MODE == 'demo'):
    ?>
<div class="uk-text-center">
    <h4 class="txt-31">Simple Data</h4>
    <p class="txt-32"><b>Card Number: </b>4242424242424242</p>
    <p class="txt-32"><b>Expiry Date: </b> <span>12/24</span></p>
    <p class="txt-32"><b>CVC Code: </b>123</p>
</div>
<?php
    endif;
?>

<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v3/"></script>

<?php
    //get payment setting
    $paymentSetting = paymentSetting();
    $stripe_publishable_key = '';
    if(isset($paymentSetting) && $paymentSetting->field_3 && $paymentSetting->field_3==1):
        $stripe_publishable_key = $paymentSetting->field_3_key_2;
    endif;
?>
<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    //get publishable key
    //use this key in external stripe.js file
    var share_key = "<?php echo escape_output($stripe_publishable_key)?>";
</script>

<script src="<?php echo base_url()?>assets/landing/js/stripe.js"></script>