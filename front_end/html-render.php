<?php


class HTML {

    private function add_html_input($option,$class,$type,$title) {
        global $help;
        if ($help->filter_option($option) !== false):?>
            <div class="<?php echo $class;?>">
                <label for="<?php echo $option;?>"><?php echo $title;?></label>
                <input type="<?php echo $type;?>" class="form-control" name="<?php echo $option;?>" value="<?php echo get_option($option);?>">
            </div>
        <?php endif;
    }

    private function add_html_checkbox($option,$class,$title,$key) {
        global $help;
        if ($help->filter_option($option,false)):?>
            <div class="<?php echo $class;?>">
                <label for="<?php echo $option;?>"><?php echo $title;?></label>
                <input type="checkbox" data-key="<?php echo $key;?>" name="<?php echo $option;?>">
            </div>
        <?php endif;
    }

    function general_inputs() {?>
        <div class="-pap-header-form">
            <form class="form-group row">
                <?php
                    $this->add_html_input('-pap-company_name','-pap-company_name col-md-6','text','Company Name');
                    $this->add_html_input('-pap-address_data','-pap-address_data col-md-6','text','Street & House Number');
                    $this->add_html_input('-pap-zip','-pap-zip col-md-4','text','Zip Code');
                    $this->add_html_input('-pap-city','-pap-city col-md-4','text','City');
                    $this->add_html_input('-pap-country','-pap-country col-md-4','text','Country');
                    $this->add_html_input('-pap-phone','-pap-phone col-md-6','text','Phone');
                    $this->add_html_input('-pap-email','-pap-email col-md-6','email','Email');
                ?>
            </form>
        </div>
    <?php }

    function website_inputs() {?>
        <div id="pap-general" class="tab-pane  fade in active">
            <h6>GENERAL INFORMATION ABOUT THE WEBSITE</h6>
            <p class="text-dark">At the beginning some general information about your website need to be provided. Please mark all that is applicable:
            </p>
            <?php
                $this->add_html_checkbox('-pap-cookies','-pap-cookies','We use cookies','Cookies');
                $this->add_html_checkbox('-pap-register','-pap-register','Customers can register with us.','Register');
            ?>
        </div>
    <?php }

    function social_inputs() {?>
        <div id="pap-social" class="tab-pane fade">
            <h6>CONNECTIONS TO SOCIAL MEDIA</h6>
            <p class="text-dark">On many websites there are small icons, which invite the visitor to use social media (Facebook and Co.) of the website operator. If your website refers to such services, you should list all the links to the social networks in your Privacy Policy.
                Please mark which of the following services are integrated on your website.</p>
            <?php
                $this->add_html_checkbox('-pap-facebook','-pap-facebook','Facebook','Facebook');
                $this->add_html_checkbox('-pap-instagram','-pap-instagram','Instagram','Instagram');
            ?>
        </div>
    <?php }

    function payment_inputs() {?>
        <div id="pap-payment" class="tab-pane fade">
            <h6>USE OF PAYMENT SERVICES</h6>
            <p class="text-dark">Anyone who offers services or products on the Internet usually uses at
                least one third party to process its payments. To add the relevant sections to your Privacy Policy, please select all payment providers.
            </p>
            <?php
                $this->add_html_checkbox('-pap-klarna','-pap-klarna','Klarna','Klarna');
                $this->add_html_checkbox('-pap-paypal','-pap-paypal','Paypal','Paypal');
            ?>
        </div>
    <?php }


    function createFrontHtml($gen,$web,$soc,$pay) {

        $general_inputs  = get_option('-pap-general_config_state');
        $website_inputs  = get_option('-pap-website_config_state');
        $social_inputs  = get_option('-pap-social_config_state');
        $payment_inputs  = get_option('-pap-payment_config_state');
        $isActive = 0;
        if($website_inputs )
            $isActive = 1;
        if($social_inputs )
            $isActive = 2;
        if($payment_inputs )
            $isActive = 3;
        ?>
        <div class="-pap-wrapper container-fluid">
            <!-- general inputs -->
            <?php $general_inputs && $gen && $this->general_inputs();?>
            <div class="-pap-body-form row">
                <div class="-pap-body-sidebar col-md-3">
                    <ul class="nav nav-tabs">
                        <?php if($website_inputs && $web):?>
                            <li class="<?php echo ($isActive== 1)?" active ":"";?> text-center"><a  data-toggle="tab"  href="#pap-general">General</a></li>
                        <?php endif;?>
                        <?php if($social_inputs && $soc):?>
                            <li class="<?php echo ($isActive== 2)?" active ":"";?> text-center"><a  data-toggle="tab"  href="#pap-social">Social Media</a></li>
                        <?php endif;?>
                        <?php if($payment_inputs && $pay):?>
                            <li class="<?php echo ($isActive== 2)?" active ":"";?> text-center"><a  data-toggle="tab"  href="#pap-payment">Payment Options</a></li>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="-pap-body-form-content col-md-9">
                    <form class="form-group row tab-content">
                        <!-- website inputs -->
                        <?php $website_inputs && $web && $this->website_inputs();?>
                        <!-- social inputs -->
                        <?php $social_inputs && $soc && $this->social_inputs();?>
                        <!-- payment inputs -->
                        <?php $payment_inputs && $pay && $this->payment_inputs();?>
                    </form>
                </div>
            </div>
            <div class="text-center">
                <button class="generate-html" class="btn btn-info btn-lg">Generate</button>
            </div>
        </div>
        <?php
    }

}
$html = new HTML;
