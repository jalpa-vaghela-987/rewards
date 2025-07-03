<?php

namespace Database\Factories;

use App\Models\Redemption;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedemptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Redemption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->panera['data'] = file_get_contents(public_path('db_json/panera.json'));
        $this->tjx['data'] = file_get_contents(public_path('db_json/tjx.json'));
        $this->home_depot['data'] = file_get_contents(public_path('db_json/home_depot.json'));
        $this->target['data'] = file_get_contents(public_path('db_json/target.json'));

//        pankaj - for some reason the public_path was not working so I had to put back the old code
        // $this->panera['data'] = Storage::disk('local')->get('db_json/panera.json');
        // $this->tjx['data'] = Storage::disk('local')->get('db_json/tjx.json');
        // $this->home_depot['data'] = Storage::disk('local')->get('db_json/home_depot.json');
        // $this->target['data'] = Storage::disk('local')->get('db_json/target.json');

        $rewards = [
             $this->tjx,
            $this->panera,
             //$this->bloomin,
              $this->home_depot,
              $this->target,
              $this->tshirt,
              $this->store_card,
        ];

        $r = $rewards[rand(0, 5)];
        $r['user_id'] = User::all()->where('company_id', 2)->random();
        $r['created_at'] = Carbon::parse($this->rand_date(now()->subMonths(4), now()));
        $r['updated_at'] = $r['created_at'];

        return $r;
    }

    public function rand_date($min_date, $max_date)
    {
        /* Gets 2 dates as string, earlier and later date.
           Returns date in between them.
        */

        $min_epoch = strtotime($min_date);
        $max_epoch = strtotime($max_date);

        $rand_epoch = rand($min_epoch, $max_epoch);

        return date('Y-m-d H:i:s', $rand_epoch);
    }

    public $bloomin = [

            'reward_id'=>1,
            'value'=>10,
            'cost'=>1000,
            'redemption_instructions' => '<p>Click on the Redemption URL provided to access your Bloomin&#39; Brands eGiftCard.&nbsp; You can redeem your eGiftCard at any Bloomin&#39; Brands restaurant in the United States as well as Outback locations in Puerto Rico and Guam.&nbsp; For locations visit <a href="http://www.bloominbrands.com">www.bloominbrands.com</a>.</p>\r\n',
            'data' => '{"photo_path":"https:\/\/dwwvg90koz96l.cloudfront.net\/images\/brands\/b314169-300w-326ppi.png"}',
             'redemption_code' => 'c-e96-6113',
             'tango_order_id' => 'RA210726-40871-55',
             'tango_customer_id' => 'G31122875',
             'tango_account_id' => 'A58963409',
             'tango_created_at' => '2021-07-26T23:02:40.774Z',
             'tango_status' => 'COMPLETE',
             'tango_amount' => '10',
             'tango_utid' => 'U810083',
             'tango_reward_name' => "Bloomin\' Brands eGiftCard",
             'redemption_code' => 'c-e96-6113',
             'tango_order_id' => 'RA210726-40871-55',
             'tango_customer_id' => 'G31122875',
             'tango_account_id' => 'A58963409',
             'tango_created_at' => '2021-07-26T23:02:40.774Z',
             'tango_status' => 'COMPLETE',
             'tango_amount' => '10',
             'tango_utid' => 'U810083',
             'tango_reward_name' => "Bloomin\' Brands eGiftCard",
             'tango_notes' => 'Purchased by Nick Lynch for 1000 kudos at 2021-07-26 23:02:40',
             'tango_directions' => '<p>Click on the Redemption URL provided to access your Bloomin&#39; Brands eGiftCard.&nbsp; You can redeem your eGiftCard at any Bloomin&#39; Brands restaurant in the United States as well as Outback locations in Puerto Rico and Guam.&nbsp; For locations visit <a href="http://www.bloominbrands.com">www.bloominbrands.com</a>.</p>\r\n',
             'tango_disclaimer' => null,
             'tango_terms' => null,
             'tango_data' => null,
             'tango_brand_requirements' => null,
             'tango_link' => 'https://sandbox.rewardcodes.com/r2/1/AnHs1Pg62n7KujJBYliSXg',
             'tango_claim_code' => null,
             'tango_pin' => null,
             'tango_card_number' => null,
             'is_custom' => 0,
             'marked_as_sent' => 0,
             'reminder_1_sent' => 0,
             'reminder_2_sent' => 0,
             'confirmed_reciept' => 0,
             'reward_forfeited' => 0,
             'marked_as_unable_to_furfill' => 0,
             'refund_sent' => 0,
             'created_at' => '2021-07-26 23:02:43',
             'updated_at' => '2021-07-26 23:02:43',
             //'photo_path' => 'https://dwwvg90koz96l.cloudfront.net/images/brands/b957625-300w-326ppi.png',

        ];

    public $panera = [
         'user_id' => 32,
         'reward_id' => 119,
         'data' => '{"photo_path":"https:\/\/dwwvg90koz96l.cloudfront.net\/images\/brands\/b314169-300w-326ppi.png"}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 15.0,
         'cost' => 1500,
         'redemption_instructions' => '"
           <p><strong>Using your eGift Card is simple!</strong></p>\n
           <p><strong>Redeem Online or In the Panera App*</strong></p>\n
           <ol>\n
           <li>Order for Panera&reg; Curbside, Rapid Pick-Up&reg; or Contactless Delivery at <a href="https://www.panerabread.com/en-us/home.html">PaneraBread.com</a> or in the app.</li>\n
           <li>Enter and apply Gift Card and 4-digit PIN number during checkout. Be sure to save your PIN for future in-cafe use.</li>\n
           </ol>\n
           <p>*Minimum order of $5 required for delivery, exclusive of taxes and delivery charges that may apply. Delivery charges may vary. Our delivery charge is not a tip or gratuity provided to the driver. Participating bakery-cafes only. Tracking available only in participating bakery-cafes that offer delivery. Gift card purchases and catering orders excluded. Order must be placed online with credit card. Other restrictions may apply. Delivery hours may vary. Limited delivery area. Visit <a href="https://www.panerabread.com/en-us/company/ordering-help.html">panerabread.com/deliveryinfo</a> to determine if you&rsquo;re in a delivery area or for more information. Drive thru availability varies by location.</p>\n
           <p><strong>Redeem in Cafe or in the Drive-Thru</strong></p>\n
           <ol>\n
           <li>Print this page, or save to show on your mobile device.</li>\n
           <li>Bring it to any participating U.S. Panera Bread&reg; bakery-cafe location and present at checkout.</li>\n
           </ol>\n
           <p>&nbsp;</p>\n
           <p><strong>Merchant Instructions:</strong></p>\n
           <ol>\n
           <li>At Pay Screen, press Gift Card button.</li>\n
           <li>When prompted to swipe Gift Card, click on Manual button.</li>\n
           <li>Enter gift card digits.</li>\n
           <li>Click Enter.</li>\n
           <li>Enter PIN digits.</li>\n
           <li>Click Enter.</li>\n
           <li>Follow normal procedure to close out the check.</li>\n
           </ol>
           "',
         'redemption_code' => '8e05018-b2',
         'tango_order_id' => 'RA210727-40872-15',
         'tango_customer_id' => 'G31122875',
         'tango_account_id' => 'A58963409',
         'tango_created_at' => '2021-07-27T00:52:12.063Z',
         'tango_status' => 'COMPLETE',
         'tango_amount' => '15',
         'tango_utid' => 'U455508',
         'tango_reward_name' => 'Panera Bread eGift Card',
         'tango_notes' => 'Purchased by Nick Lynch for 1500 kudos at 2021-07-27 00:52:11',
         'tango_directions' => '"
           <p><strong>Using your eGift Card is simple!</strong></p>\n
           <p><strong>Redeem Online or In the Panera App*</strong></p>\n
           <ol>\n
           <li>Order for Panera&reg; Curbside, Rapid Pick-Up&reg; or Contactless Delivery at <a href="https://www.panerabread.com/en-us/home.html">PaneraBread.com</a> or in the app.</li>\n
           <li>Enter and apply Gift Card and 4-digit PIN number during checkout. Be sure to save your PIN for future in-cafe use.</li>\n
           </ol>\n
           <p>*Minimum order of $5 required for delivery, exclusive of taxes and delivery charges that may apply. Delivery charges may vary. Our delivery charge is not a tip or gratuity provided to the driver. Participating bakery-cafes only. Tracking available only in participating bakery-cafes that offer delivery. Gift card purchases and catering orders excluded. Order must be placed online with credit card. Other restrictions may apply. Delivery hours may vary. Limited delivery area. Visit <a href="https://www.panerabread.com/en-us/company/ordering-help.html">panerabread.com/deliveryinfo</a> to determine if you&rsquo;re in a delivery area or for more information. Drive thru availability varies by location.</p>\n
           <p><strong>Redeem in Cafe or in the Drive-Thru</strong></p>\n
           <ol>\n
           <li>Print this page, or save to show on your mobile device.</li>\n
           <li>Bring it to any participating U.S. Panera Bread&reg; bakery-cafe location and present at checkout.</li>\n
           </ol>\n
           <p>&nbsp;</p>\n
           <p><strong>Merchant Instructions:</strong></p>\n
           <ol>\n
           <li>At Pay Screen, press Gift Card button.</li>\n
           <li>When prompted to swipe Gift Card, click on Manual button.</li>\n
           <li>Enter gift card digits.</li>\n
           <li>Click Enter.</li>\n
           <li>Enter PIN digits.</li>\n
           <li>Click Enter.</li>\n
           <li>Follow normal procedure to close out the check.</li>\n
           </ol>
           "',
         'tango_disclaimer' => null,
         'tango_terms' => null,
         'tango_data' => null,
         'tango_brand_requirements' => null,
         'tango_link' => 'https://sandbox.rewardcodes.com/r2/1/CyVlupLF-dk-C8DG5mqpiw',
         'tango_claim_code' => null,
         'tango_pin' => null,
         'tango_card_number' => null,
         'is_custom' => 0,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 00:52:14',
         'updated_at' => '2021-07-27 00:52:14',
         //'photo_path' => 'https://dwwvg90koz96l.cloudfront.net/images/brands/b209069-300w-326ppi.png',
 ];

    public $home_depot = [
         'reward_id' => 170,
         'data' => '{"photo_path":"https:\/\/dwwvg90koz96l.cloudfront.net\/images\/brands\/b314169-300w-326ppi.png"}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 15.0,
         'cost' => 1500,
         'redemption_instructions' => '""
           <ol>\r\n
           \t<li>Click on the Redemption URL provided above.</li>\r\n
           \t<li>Print the resulting page or show cashier barcode for scanning.</li>\r\n
           </ol>\r\n
           \r\n
           <p>The Home Depot&reg; Gift Cards are valid for use in store or online.&nbsp; If you have any problems or questions please visit&nbsp;<a href="https://www.homedepot.com/c/Gift_Card_FAQ">https://www.homedepot.com/c/Gift_Card_FAQ</a>.</p>\r\n
           ""',
         'redemption_code' => '5-97f0a46d',
         'tango_order_id' => 'RA210727-40872-33',
         'tango_customer_id' => 'G31122875',
         'tango_account_id' => 'A58963409',
         'tango_created_at' => '2021-07-27T01:36:17.108Z',
         'tango_status' => 'COMPLETE',
         'tango_amount' => '15',
         'tango_utid' => 'U231646',
         'tango_reward_name' => 'The Home Depot® eGift Card',
         'tango_notes' => 'Purchased by Nick Lynch for 1500 kudos at 2021-07-27 01:36:16',
         'tango_directions' => '""
           <ol>\r\n
           \t<li>Click on the Redemption URL provided above.</li>\r\n
           \t<li>Print the resulting page or show cashier barcode for scanning.</li>\r\n
           </ol>\r\n
           \r\n
           <p>The Home Depot&reg; Gift Cards are valid for use in store or online.&nbsp; If you have any problems or questions please visit&nbsp;<a href="https://www.homedepot.com/c/Gift_Card_FAQ">https://www.homedepot.com/c/Gift_Card_FAQ</a>.</p>\r\n
           ""',
         'tango_disclaimer' => null,
         'tango_terms' => null,
         'tango_data' => null,
         'tango_brand_requirements' => null,
         'tango_link' => 'https://sandbox.rewardcodes.com/r2/1/g-b5f9RFy3eKdolS6kZwpw',
         'tango_claim_code' => null,
         'tango_pin' => null,
         'tango_card_number' => null,
         'is_custom' => 0,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 01:36:21',
         'updated_at' => '2021-07-27 01:36:21',
 ];

    public $tjx = [
         'reward_id' => 259,
         'data' => '{"id":259,"cost":0,"min_value":10,"max_value":100,"value":0,"type":"default","issuer_id":0,"title":"TJX eGift Card","description":"<p>Enjoy more stores, more savings, and more smiles with a TJX Gift Card. All of our stores offer a unique selection of top-quality brands for you, your family and your home. And, with our amazing prices, you can spend less and buy so much more. <strong>TJX Gift Cards are redeemable at over 3300 T.J.Maxx&reg;, Marshalls&reg;, HomeGoods&reg;, Homesense&trade; and Sierra&reg; stores (in the U.S. and Puerto Rico) and online at <a href=\"http:\/\/tjmaxx.com\">tjmaxx.com<\/a>, <a href=\"http:\/\/marshalls.com\">marshalls.com<\/a>, and <a href=\"http:\/\/sierra.com\">sierra.com<\/a>.<\/strong><\/p>","hidden":0,"remaining_amount":100,"photo_path":"https:\/\/dwwvg90koz96l.cloudfront.net\/images\/brands\/b314169-300w-326ppi.png","active":1,"tango_disclaimer":"<p>T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra are not affiliated with this company and are not sponsors or co-sponsors with this promotion.&nbsp; Use of T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra names, logos, images, or trademarks require written approval from TJX Incentive Sales, Inc. Participation by T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra in the program is not intended as, and shall not constitute, a promotion or marketing of the program by T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra, The TJX Companies, Inc, or any of its subsidiaries or affiliates.<\/p>\r\n","tango_terms":"<p>For balance inquiry, please check your most recent receipt, visit&nbsp;<a href=\"http:\/\/www.tjmaxx.com\/\">tjmaxx.com<\/a>&nbsp;or bring your eGift Card to any T.J.Maxx, Marshalls, HomeGoods, or Sierra Trading Post store and an associate will be happy to provide you with your balance. Use of this eGift Card constitutes acceptance of the following terms. The eGift Card cannot be redeemed until activated. Purchases with the card will be deducted from the balance until it reaches $0.00. The eGift Card is redeemable for merchandise only at T.J.Maxx,&nbsp;<a href=\"http:\/\/tjmaxx.com\/\">tjmaxx.com<\/a>, Marshalls, HomeGoods, and Sierra Trading Post (in the U.S. and Puerto Rico) and cannot be redeemed for cash except where required by law. If lost or stolen, it will not be replaced. This eGift Card has no expiration date and incurs no dormancy fees. Any term is void where prohibited by law. This eGift Card is issued by and represents an obligation of TJX Incentive Sales, Inc., a Virginia corporation. T.J.Maxx, Marshalls, HomeGoods, and Sierra Trading Post are registered trademarks of the TJX Companies, Inc.<\/p>\r\n","tango_data":"{\"brandKey\":\"B314169\",\"brandName\":\"TJX\",\"disclaimer\":\"<p>T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra are not affiliated with this company and are not sponsors or co-sponsors with this promotion.&nbsp; Use of T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra names, logos, images, or trademarks require written approval from TJX Incentive Sales, Inc. Participation by T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra in the program is not intended as, and shall not constitute, a promotion or marketing of the program by T.J.Maxx, Marshalls, HomeGoods, Homesense, and Sierra, The TJX Companies, Inc, or any of its subsidiaries or affiliates.<\\\/p>\\r\\n\",\"description\":\"<p>Enjoy more stores, more savings, and more smiles with a TJX Gift Card. All of our stores offer a unique selection of top-quality brands for you, your family and your home. And, with our amazing prices, you can spend less and buy so much more. <strong>TJX Gift Cards are redeemable at over 3300 T.J.Maxx&reg;, Marshalls&reg;, HomeGoods&reg;, Homesense&trade; and Sierra&reg; stores (in the U.S. and Puerto Rico) and online at <a href=\\\"http:\\\/\\\/tjmaxx.com\\\">tjmaxx.com<\\\/a>, <a href=\\\"http:\\\/\\\/marshalls.com\\\">marshalls.com<\\\/a>, and <a href=\\\"http:\\\/\\\/sierra.com\\\">sierra.com<\\\/a>.<\\\/strong><\\\/p>\",\"shortDescription\":\"<p>Enjoy more stores, more savings, and more smiles with a TJX Gift Card. All of our stores offer a unique selection of top-quality brands for you, your family and your home. And, with our amazing prices, you can spend less and buy so much more. <strong>TJX Gift Cards are redeemable at over 3300 T.J.Maxx&reg;, Marshalls&reg;, HomeGoods&reg;, Homesense&trade; and Sierra&reg; stores (in the U.S. and Puerto Rico) and online at <a href=\\\"http:\\\/\\\/tjmaxx.com\\\">tjmaxx.com<\\\/a>, <a href=\\\"http:\\\/\\\/marshalls.com\\\">marshalls.com<\\\/a>, and <a href=\\\"http:\\\/\\\/sierra.com\\\">sierra.com<\\\/a>.<\\\/strong><\\\/p>\",\"terms\":\"<p>For balance inquiry, please check your most recent receipt, visit&nbsp;<a href=\\\"http:\\\/\\\/www.tjmaxx.com\\\/\\\">tjmaxx.com<\\\/a>&nbsp;or bring your eGift Card to any T.J.Maxx, Marshalls, HomeGoods, or Sierra Trading Post store and an associate will be happy to provide you with your balance. Use of this eGift Card constitutes acceptance of the following terms. The eGift Card cannot be redeemed until activated. Purchases with the card will be deducted from the balance until it reaches $0.00. The eGift Card is redeemable for merchandise only at T.J.Maxx,&nbsp;<a href=\\\"http:\\\/\\\/tjmaxx.com\\\/\\\">tjmaxx.com<\\\/a>, Marshalls, HomeGoods, and Sierra Trading Post (in the U.S. and Puerto Rico) and cannot be redeemed for cash except where required by law. If lost or stolen, it will not be replaced. This eGift Card has no expiration date and incurs no dormancy fees. Any term is void where prohibited by law. This eGift Card is issued by and represents an obligation of TJX Incentive Sales, Inc., a Virginia corporation. T.J.Maxx, Marshalls, HomeGoods, and Sierra Trading Post are registered trademarks of the TJX Companies, Inc.<\\\/p>\\r\\n\",\"createdDate\":\"2016-04-26T20:04:19Z\",\"lastUpdateDate\":\"2021-03-09T16:40:13Z\",\"brandRequirements\":{\"displayInstructions\":\"\",\"termsAndConditionsInstructions\":\"\",\"disclaimerInstructions\":\"\",\"alwaysShowDisclaimer\":false},\"imageUrls\":{\"80w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-80w-326ppi.png\",\"130w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-130w-326ppi.png\",\"200w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-200w-326ppi.png\",\"278w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-278w-326ppi.png\",\"300w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-300w-326ppi.png\",\"1200w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b314169-1200w-326ppi.png\"},\"status\":\"active\",\"items\":[{\"utid\":\"U553871\",\"rewardName\":\"TJX eGift Card\",\"currencyCode\":\"USD\",\"status\":\"active\",\"valueType\":\"VARIABLE_VALUE\",\"rewardType\":\"gift card\",\"isWholeAmountValueRequired\":false,\"minValue\":5,\"maxValue\":500,\"createdDate\":\"2016-04-26T20:47:18.09Z\",\"lastUpdateDate\":\"2020-07-31T23:13:19.853Z\",\"countries\":[\"PR\",\"US\"],\"credentialTypes\":[\"cardNumber\",\"landingPage\",\"pin\"],\"redemptionInstructions\":\"<ol>\\r\\n\\t<li>Click the Redemption URL above. You will be presented with a Barcode, Card Number, and Card Security Code (CSC).<\\\/li>\\r\\n\\t<li>Print the resulting page.<\\\/li>\\r\\n<\\\/ol>\\r\\n\\r\\n<p><strong>To Redeem In Store:<\\\/strong><\\\/p>\\r\\n\\r\\n<p>Bring it into any T.J.Maxx, Marshalls, HomeGoods, Sierra or Homesense store and present to cashier.<\\\/p>\\r\\n\\r\\n<p><strong>To Redeem Online:<\\\/strong><br \\\/>\\r\\nVisit&nbsp;<a href=\\\"http:\\\/\\\/tjmaxx.tjx.com\\\/\\\">tjmaxx.com<\\\/a>,&nbsp;or&nbsp;<a href=\\\"http:\\\/\\\/sierratradingpost.com\\\/\\\">sierratradingpost.com<\\\/a>&nbsp;and enter your card number and CSC during checkout.<\\\/p>\\r\\n\"}]}","tango_status":"active","tango_description":null,"tango_brand_requirements":"{\"displayInstructions\":\"\",\"termsAndConditionsInstructions\":\"\",\"disclaimerInstructions\":\"\",\"alwaysShowDisclaimer\":false}","tango_redemption_instructions":"<ol>\r\n\t<li>Click the Redemption URL above. You will be presented with a Barcode, Card Number, and Card Security Code (CSC).<\/li>\r\n\t<li>Print the resulting page.<\/li>\r\n<\/ol>\r\n\r\n<p><strong>To Redeem In Store:<\/strong><\/p>\r\n\r\n<p>Bring it into any T.J.Maxx, Marshalls, HomeGoods, Sierra or Homesense store and present to cashier.<\/p>\r\n\r\n<p><strong>To Redeem Online:<\/strong><br \/>\r\nVisit&nbsp;<a href=\"http:\/\/tjmaxx.tjx.com\/\">tjmaxx.com<\/a>,&nbsp;or&nbsp;<a href=\"http:\/\/sierratradingpost.com\/\">sierratradingpost.com<\/a>&nbsp;and enter your card number and CSC during checkout.<\/p>\r\n","brand_key":"B314169","tango_utid":"U553871","is_custom":0,"required_authorization":0,"company_id":null,"creator_id":null,"custom_redemption_instructions":null,"expected_timeframe":null,"require_verification":0,"is_digital":0,"stock_amount":0,"use_set_amount":0,"min_kudos_value":0,"max_kudos_value":100000,"kudos_conversion_rate":100,"disabled":0,"admin_id":null,"alt_admin_id":null,"alt3_admin_id":null,"created_at":"2021-07-27T01:41:07.000000Z","updated_at":"2021-07-27T01:41:07.000000Z","tango_reward_url":null,"enable_inventory_tracking":null,"inventory_redeemed":null,"inventory_confirmed":null}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 20.0,
         'cost' => 2000,
         'redemption_instructions' => '"""
           <ol>\r\n
           \t<li>Click the Redemption URL above. You will be presented with a Barcode, Card Number, and Card Security Code (CSC).</li>\r\n
           \t<li>Print the resulting page.</li>\r\n
           </ol>\r\n
           \r\n
           <p><strong>To Redeem In Store:</strong></p>\r\n
           \r\n
           <p>Bring it into any T.J.Maxx, Marshalls, HomeGoods, Sierra or Homesense store and present to cashier.</p>\r\n
           \r\n
           <p><strong>To Redeem Online:</strong><br />\r\n
           Visit&nbsp;<a href="http://tjmaxx.tjx.com/">tjmaxx.com</a>,&nbsp;or&nbsp;<a href="http://sierratradingpost.com/">sierratradingpost.com</a>&nbsp;and enter your card number and CSC during checkout.</p>\r\n
           """',
         'redemption_code' => 'f-b19c4491',
         'tango_order_id' => 'RA210727-40872-34',
         'tango_customer_id' => 'G31122875',
         'tango_account_id' => 'A58963409',
         'tango_created_at' => '2021-07-27T01:41:29.623Z',
         'tango_status' => 'COMPLETE',
         'tango_amount' => '20',
         'tango_utid' => 'U553871',
         'tango_reward_name' => 'TJX eGift Card',
         'tango_notes' => 'Purchased by Chris Adams for 2000 kudos at 2021-07-27 01:41:29',
         'tango_directions' => '"""
           <ol>\r\n
           \t<li>Click the Redemption URL above. You will be presented with a Barcode, Card Number, and Card Security Code (CSC).</li>\r\n
           \t<li>Print the resulting page.</li>\r\n
           </ol>\r\n
           \r\n
           <p><strong>To Redeem In Store:</strong></p>\r\n
           \r\n
           <p>Bring it into any T.J.Maxx, Marshalls, HomeGoods, Sierra or Homesense store and present to cashier.</p>\r\n
           \r\n
           <p><strong>To Redeem Online:</strong><br />\r\n
           Visit&nbsp;<a href="http://tjmaxx.tjx.com/">tjmaxx.com</a>,&nbsp;or&nbsp;<a href="http://sierratradingpost.com/">sierratradingpost.com</a>&nbsp;and enter your card number and CSC during checkout.</p>\r\n
           """',
         'tango_disclaimer' => null,
         'tango_terms' => null,
         'tango_data' => null,
         'tango_brand_requirements' => null,
         'tango_link' => 'https://sandbox.rewardcodes.com/r2/1/8o2gbZDiZk1I7JBm9K8GkQ',
         'tango_claim_code' => null,
         'tango_pin' => null,
         'tango_card_number' => null,
         'is_custom' => 0,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 01:41:31',
         'updated_at' => '2021-07-27 01:41:31',
        // 'photo_path' => 'https://dwwvg90koz96l.cloudfront.net/images/brands/b314169-300w-326ppi.png',
 ];

    public $target = [

         'reward_id' => 301,
         'data' => '{"id":301,"cost":0,"min_value":10,"max_value":100,"value":0,"type":"default","issuer_id":0,"title":"Target eGiftCard","description":"<p>Target GiftCards let them choose their own reward. Good at over 1,800 Target stores in the U.S. and at <a href=\"https:\/\/www.target.com\/\">Target.com<\/a>.<\/p>","hidden":0,"remaining_amount":100,"photo_path":"https:\/\/dwwvg90koz96l.cloudfront.net\/images\/brands\/b663882-300w-326ppi.png","active":1,"tango_disclaimer":"<p>Target and the Bullseye Design are registered trademarks of Target Brands, Inc. Terms and conditions are applied to gift cards. Target is not a participating partner in or sponsor of this offer.<\/p>","tango_terms":"<p>This Gift Card can be redeemed for merchandise or services (other than gift cards and prepaid cards) at Target stores in the U.S. or&nbsp;<a href=\"http:\/\/target.com\/\">Target.com<\/a>, and cannot be redeemed for cash or credit except where required by law. No value until purchased. For balance information, visit&nbsp;<a href=\"http:\/\/www.target.com\/giftcards\">www.target.com\/giftcards<\/a>&nbsp;or call 1-800-544-2943. To replace the remaining value on a lost, stolen or damaged card with the original purchase receipt, 1-800-544-2943. &copy; 2020&nbsp;Target Brands, Inc. The Bullseye Design, Bullseye Dog and Target are trademarks of Target Brands, Inc. 1212 1897.<\/p>\n<p>Target and the Bullseye Design are registered trademarks of Target Brands, Inc. Terms and conditions are applied to gift cards. Target is not a participating partner in or sponsor of this offer.<\/p>","tango_data":"{\"brandKey\":\"B663882\",\"brandName\":\"Target\",\"disclaimer\":\"<p>Target and the Bullseye Design are registered trademarks of Target Brands, Inc. Terms and conditions are applied to gift cards. Target is not a participating partner in or sponsor of this offer.<\\\/p>\",\"description\":\"<p>Target GiftCards are the rewarding choice, letting you shop for thousands of items at more than 1,800 Target stores in the U.S. and online at <a href=\\\"https:\\\/\\\/www.target.com\\\/\\\">Target.com<\\\/a>. From toys and electronics to clothing and housewares, find exactly what you&#39;re looking for at Target.<\\\/p>\",\"shortDescription\":\"<p>Target GiftCards let them choose their own reward. Good at over 1,800 Target stores in the U.S. and at <a href=\\\"https:\\\/\\\/www.target.com\\\/\\\">Target.com<\\\/a>.<\\\/p>\",\"terms\":\"<p>This Gift Card can be redeemed for merchandise or services (other than gift cards and prepaid cards) at Target stores in the U.S. or&nbsp;<a href=\\\"http:\\\/\\\/target.com\\\/\\\">Target.com<\\\/a>, and cannot be redeemed for cash or credit except where required by law. No value until purchased. For balance information, visit&nbsp;<a href=\\\"http:\\\/\\\/www.target.com\\\/giftcards\\\">www.target.com\\\/giftcards<\\\/a>&nbsp;or call 1-800-544-2943. To replace the remaining value on a lost, stolen or damaged card with the original purchase receipt, 1-800-544-2943. &copy; 2020&nbsp;Target Brands, Inc. The Bullseye Design, Bullseye Dog and Target are trademarks of Target Brands, Inc. 1212 1897.<\\\/p>\\n<p>Target and the Bullseye Design are registered trademarks of Target Brands, Inc. Terms and conditions are applied to gift cards. Target is not a participating partner in or sponsor of this offer.<\\\/p>\",\"createdDate\":\"2016-04-26T23:02:52Z\",\"lastUpdateDate\":\"2021-05-13T18:16:38Z\",\"brandRequirements\":{\"displayInstructions\":\"<p>Target cannot be mentioned in the subject-line of eGiftCard delivery messages or promotional emails.<br \\\/>The Target GiftCard image cannot be positioned at the top of your promotional material, tilted or rotated.<br \\\/>All Target GiftCard images must be less visually prominent than your company&rsquo;s identity. At no time should the Target GiftCard image dominate or compete with your company&rsquo;s identity.<br \\\/>When referring to Target eGiftCards in offer: The offer must be stated in the correct order: &ldquo;Do X, and receive a Target eGiftCard.&rdquo;<br \\\/>The Target Brand Disclaimer is to be used everywhere Target is presented, on a page or in an email. Target is NOT covered under general merchant disclaimers. Use minimum 6-point type for disclaimers.<br \\\/>Present the Terms and Conditions anytime you&rsquo;re presenting specific gift card use details.<\\\/p>\",\"termsAndConditionsInstructions\":\"\",\"disclaimerInstructions\":\"\",\"alwaysShowDisclaimer\":true},\"imageUrls\":{\"80w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-80w-326ppi.png\",\"130w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-130w-326ppi.png\",\"200w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-200w-326ppi.png\",\"278w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-278w-326ppi.png\",\"300w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-300w-326ppi.png\",\"1200w-326ppi\":\"https:\\\/\\\/dwwvg90koz96l.cloudfront.net\\\/images\\\/brands\\\/b663882-1200w-326ppi.png\"},\"status\":\"active\",\"items\":[{\"utid\":\"U084922\",\"rewardName\":\"Target eGiftCard\",\"currencyCode\":\"USD\",\"status\":\"active\",\"valueType\":\"VARIABLE_VALUE\",\"rewardType\":\"gift card\",\"isWholeAmountValueRequired\":false,\"minValue\":1,\"maxValue\":2000,\"createdDate\":\"2016-04-26T23:10:06.186Z\",\"lastUpdateDate\":\"2020-12-17T21:41:04.017Z\",\"countries\":[\"US\"],\"credentialTypes\":[\"bypassUrl\"],\"redemptionInstructions\":\"<p><strong>To redeem your Target eGiftCard&nbsp;at a Target store in the U.S.:<\\\/strong><\\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>Using your web-enabled mobile device. Click on the Redemption URL.<\\\/li>\\r\\n\\t<li>At check out, a Target team member will scan the Target eGiftCard barcode.<\\\/li>\\r\\n<\\\/ol>\\r\\n\\r\\n<p><strong>-Or-<\\\/strong><\\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>Open this email from a device connected to a printer. Click on the Redemption URL provided above.<\\\/li>\\r\\n\\t<li>Print the resulting eGiftCard page. The Gift Card Number, Access Number, Event Number, and eGiftCard barcode need to be visible on the eGiftCard printout.<\\\/li>\\r\\n\\t<li>At check out, a Target team member will scan the Target eGiftCard barcode.<\\\/li>\\r\\n<\\\/ol>\\r\\n\\r\\n<p><strong>To redeem your Target eGiftCard on www.Target.com:<\\\/strong><\\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>Click on the Redemption URL provided above.<\\\/li>\\r\\n\\t<li>Visit <a href=\\\"http:\\\/\\\/www.Target.com\\\">www.Target.com<\\\/a> on your computer or mobile device.<\\\/li>\\r\\n\\t<li>Enter your Target eGiftCard number and access number when checking out.<\\\/li>\\r\\n\\t<li>Your eGiftCard will automatically be applied.<\\\/li>\\r\\n<\\\/ol>\\r\\n\\r\\n<p><strong>To save to your Target.com account:<\\\/strong><\\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>Click on the Redemption URL provided above.<\\\/li>\\r\\n\\t<li>Visit <a href=\\\"http:\\\/\\\/www.Target.com\\\">www.Target.com<\\\/a> on your computer or mobile device.<\\\/li>\\r\\n\\t<li>Sign in to your account and add this gift card.<\\\/li>\\r\\n\\t<li>Pay in the store when you&#39;re signed into Target.com on your mobile device.<\\\/li>\\r\\n<\\\/ol>\\r\\n\"}]}","tango_status":"active","tango_description":null,"tango_brand_requirements":"{\"displayInstructions\":\"<p>Target cannot be mentioned in the subject-line of eGiftCard delivery messages or promotional emails.<br \\\/>The Target GiftCard image cannot be positioned at the top of your promotional material, tilted or rotated.<br \\\/>All Target GiftCard images must be less visually prominent than your company&rsquo;s identity. At no time should the Target GiftCard image dominate or compete with your company&rsquo;s identity.<br \\\/>When referring to Target eGiftCards in offer: The offer must be stated in the correct order: &ldquo;Do X, and receive a Target eGiftCard.&rdquo;<br \\\/>The Target Brand Disclaimer is to be used everywhere Target is presented, on a page or in an email. Target is NOT covered under general merchant disclaimers. Use minimum 6-point type for disclaimers.<br \\\/>Present the Terms and Conditions anytime you&rsquo;re presenting specific gift card use details.<\\\/p>\",\"termsAndConditionsInstructions\":\"\",\"disclaimerInstructions\":\"\",\"alwaysShowDisclaimer\":true}","tango_redemption_instructions":"<p><strong>To redeem your Target eGiftCard&nbsp;at a Target store in the U.S.:<\/strong><\/p>\r\n\r\n<ol>\r\n\t<li>Using your web-enabled mobile device. Click on the Redemption URL.<\/li>\r\n\t<li>At check out, a Target team member will scan the Target eGiftCard barcode.<\/li>\r\n<\/ol>\r\n\r\n<p><strong>-Or-<\/strong><\/p>\r\n\r\n<ol>\r\n\t<li>Open this email from a device connected to a printer. Click on the Redemption URL provided above.<\/li>\r\n\t<li>Print the resulting eGiftCard page. The Gift Card Number, Access Number, Event Number, and eGiftCard barcode need to be visible on the eGiftCard printout.<\/li>\r\n\t<li>At check out, a Target team member will scan the Target eGiftCard barcode.<\/li>\r\n<\/ol>\r\n\r\n<p><strong>To redeem your Target eGiftCard on www.Target.com:<\/strong><\/p>\r\n\r\n<ol>\r\n\t<li>Click on the Redemption URL provided above.<\/li>\r\n\t<li>Visit <a href=\"http:\/\/www.Target.com\">www.Target.com<\/a> on your computer or mobile device.<\/li>\r\n\t<li>Enter your Target eGiftCard number and access number when checking out.<\/li>\r\n\t<li>Your eGiftCard will automatically be applied.<\/li>\r\n<\/ol>\r\n\r\n<p><strong>To save to your Target.com account:<\/strong><\/p>\r\n\r\n<ol>\r\n\t<li>Click on the Redemption URL provided above.<\/li>\r\n\t<li>Visit <a href=\"http:\/\/www.Target.com\">www.Target.com<\/a> on your computer or mobile device.<\/li>\r\n\t<li>Sign in to your account and add this gift card.<\/li>\r\n\t<li>Pay in the store when you&#39;re signed into Target.com on your mobile device.<\/li>\r\n<\/ol>\r\n","brand_key":"B663882","tango_utid":"U084922","is_custom":0,"required_authorization":0,"company_id":null,"creator_id":null,"custom_redemption_instructions":null,"expected_timeframe":null,"require_verification":0,"is_digital":0,"stock_amount":0,"use_set_amount":0,"min_kudos_value":0,"max_kudos_value":100000,"kudos_conversion_rate":100,"disabled":0,"admin_id":null,"alt_admin_id":null,"alt3_admin_id":null,"created_at":"2021-07-27T01:43:42.000000Z","updated_at":"2021-07-27T01:43:42.000000Z","tango_reward_url":null,"enable_inventory_tracking":null,"inventory_redeemed":null,"inventory_confirmed":null}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 12.0,
         'cost' => 1200,
         'redemption_instructions' => '"
           <p><strong>To redeem your Target eGiftCard&nbsp;at a Target store in the U.S.:</strong></p>\r\n
           \r\n
           <ol>\r\n
           \t<li>Using your web-enabled mobile device. Click on the Redemption URL.</li>\r\n
           \t<li>At check out, a Target team member will scan the Target eGiftCard barcode.</li>\r\n
           </ol>\r\n"',
         'redemption_code' => '8e91cf9b40',
         'tango_order_id' => 'RA210727-40872-35',
         'tango_customer_id' => 'G31122875',
         'tango_account_id' => 'A58963409',
         'tango_created_at' => '2021-07-27T01:44:02.578Z',
         'tango_status' => 'COMPLETE',
         'tango_amount' => '12',
         'tango_utid' => 'U084922',
         'tango_reward_name' => 'Target eGiftCard',
         'tango_notes' => 'Purchased by Chris Adams for 1200 kudos at 2021-07-27 01:44:02',
         'tango_directions' => '"
           <p><strong>To redeem your Target eGiftCard&nbsp;at a Target store in the U.S.:</strong></p>\r\n
           \r\n
           <ol>\r\n
           \t<li>Using your web-enabled mobile device. Click on the Redemption URL.</li>\r\n
           \t<li>At check out, a Target team member will scan the Target eGiftCard barcode.</li>\r\n
           </ol>\r\n"',
         'tango_disclaimer' => null,
         'tango_terms' => null,
         'tango_data' => null,
         'tango_brand_requirements' => null,
         'tango_link' => 'https://target.semi.cashstar.com/gift-card/view/0XL2iso576OI0rVKANp3qE7x0/SpbtCg/',
         'tango_claim_code' => null,
         'tango_pin' => null,
         'tango_card_number' => null,
         'is_custom' => 0,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 01:44:06',
         'updated_at' => '2021-07-27 01:44:06',
         //'photo_path' => 'https://dwwvg90koz96l.cloudfront.net/images/brands/b663882-300w-326ppi.png',
 ];

    public $tshirt = [
         'user_id' => 34,
         'reward_id' => 309,
         'data' => '{"id":309,"cost":1500,"min_value":0,"max_value":0,"value":0,"type":"Custom Reward","issuer_id":0,"title":"Company Water Bottle","description":"Enjoy a company water bottle!","hidden":0,"remaining_amount":100,"photo_path":null,"active":1,"tango_disclaimer":null,"tango_terms":null,"tango_data":null,"tango_status":null,"tango_description":null,"tango_brand_requirements":null,"tango_redemption_instructions":null,"brand_key":null,"tango_utid":null,"is_custom":1,"required_authorization":0,"company_id":2,"creator_id":34,"custom_redemption_instructions":"Please forward the email  to James from HR and provide the PerkSweet redemption code in the email.","expected_timeframe":null,"require_verification":0,"is_digital":0,"stock_amount":500,"use_set_amount":1,"min_kudos_value":0,"max_kudos_value":0,"kudos_conversion_rate":100,"disabled":0,"admin_id":null,"alt_admin_id":null,"alt3_admin_id":null,"created_at":"2021-07-27T02:01:31.000000Z","updated_at":"2021-07-27T02:01:31.000000Z","tango_reward_url":null,"enable_inventory_tracking":1,"inventory_redeemed":null,"inventory_confirmed":null, "photo_path":"https://www.yeti.com/dw/image/v2/BBRN_PRD/on/demandware.static/-/Sites-masterCatalog_Yeti/default/dw3c7a687b/images/pdp-Rambler/Rambler-36-oz-Bottle-with-Chug/Highlands-Olive/Rambler_36oz_Bottle_Highlands_Olive_Back_3942_Layers_F_1680x1024.png?sw=795"}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 15.0,
         'cost' => 1500,
         'redemption_instructions' => 'Please forward the email  to James from HR and provide the PerkSweet redemption code in the email.',
         'redemption_code' => '0626a78940',
         'tango_order_id' => null,
         'tango_customer_id' => null,
         'is_custom' => 1,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 02:03:09',
         'updated_at' => '2021-07-27 02:03:09',
        ];

    public $store_card = [
         'user_id' => 34,
         'reward_id' => 310,
         'data' => '{"id":310,"cost":0,"min_value":10,"max_value":100,"value":0,"type":"Custom Reward","issuer_id":0,"title":"Company Store Gift Card","description":"Redeem Kudos for anything at our company store! ","hidden":0,"remaining_amount":100,"photo_path":null,"active":1,"tango_disclaimer":null,"tango_terms":null,"tango_data":null,"tango_status":null,"tango_description":null,"tango_brand_requirements":null,"tango_redemption_instructions":null,"brand_key":null,"tango_utid":null,"is_custom":1,"required_authorization":0,"company_id":2,"creator_id":34,"custom_redemption_instructions":"Forward the email to Jake in HR and he will pass along the code to the company store.","expected_timeframe":null,"require_verification":0,"is_digital":0,"stock_amount":0,"use_set_amount":0,"min_kudos_value":1000,"max_kudos_value":10000,"kudos_conversion_rate":100,"disabled":0,"admin_id":null,"alt_admin_id":null,"alt3_admin_id":null,"created_at":"2021-07-27T02:02:50.000000Z","updated_at":"2021-07-27T02:02:50.000000Z","tango_reward_url":null,"enable_inventory_tracking":0,"inventory_redeemed":null,"inventory_confirmed":null}',
         'refund' => 0,
         'active' => 0,
         'hidden' => 0,
         'completed' => 0,
         'value' => 15.0,
         'cost' => 1500,
         'redemption_instructions' => 'Forward the email to Jake in HR and he will pass along the code to the company store.',
         'redemption_code' => '665d12--f4',
         'is_custom' => 1,
         'marked_as_sent' => 0,
         'reminder_1_sent' => 0,
         'reminder_2_sent' => 0,
         'confirmed_reciept' => 0,
         'reward_forfeited' => 0,
         'marked_as_unable_to_furfill' => 0,
         'refund_sent' => 0,
         'created_at' => '2021-07-27 02:05:18',
         'updated_at' => '2021-07-27 02:05:18',
];
}
