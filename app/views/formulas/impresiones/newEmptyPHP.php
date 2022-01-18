<?php
/**
 * Template Name: Finder Template
 *
 * @package luxe
 * @since 1.0
 */
get_header();
?>
<?php
//"vehicle_make" and "vehicle_model"



$vehicle_make = $vehicle_model = '';


if (!empty($_REQUEST['model'])) {
    $parts = explode('-', $_REQUEST['model']);
    $vehicle_make = isset($parts[0]) ? $parts[0] : null;
    $vehicle_model = isset($parts[1]) ? $parts[1] : null;
}
if (!empty($_REQUEST['brand'])) {
    $vehicle_make = $_REQUEST['brand'];
}

if ($vehicle_make) {
    $vehicle_make = array("key" => "vehicle_make", "value" => $vehicle_make, "compare" => '=');
}
if ($vehicle_model) {
    $vehicle_model = array('key' => 'vehicle_model', 'value' => $vehicle_model, "compare" => '=');
}
$query = [
    'numberposts' => -1,
    'post_type' => 'page',
    "post_status" => "publish",
    "order_by" => 'post_title',
    "order" => 'ASC'
];
$total_post = 0;
if ($vehicle_make || $vehicle_model) {
    $query ['meta_query'] = [
        'relation' => 'AND'
    ];
    if ($vehicle_make)
        $query ['meta_query'][] = $vehicle_make;
    if ($vehicle_model)
        $query ['meta_query'][] = $vehicle_model;
    $posts = new WP_Query($query);
    $total_post = $posts->post_count;
}
?>

<nav class="sticky-nav hidden-xs" data-spy="affix" data-offset-top="80" data-offset-bottom="280">
    <ul>
        <li><a href="#why-dm">Why D&M</a></li>
        <li><a href="#lease-buy">Lease Vs. Buy</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#why-fleet-lease">Benefits</a></li>
        <li><a href="#testimonialsec">Testimonials</a></li>
    </ul>
</nav>

<section class="title">
    <h1>FIND YOUR VEHICLE</h1>
</section>
<div class="clearfix"></div>
<section class="benefits-leasing">
    <p style="color: white;text-align: center;font-weight: 400; width: 70%; margin-left:auto; margin-right: auto;">D&M Leasing will deliver any make, any model vehicle right to your doorstep.
        We offer an effortless way to drive the car of your choice for a price you can
        afford. Browse the vehicles below to find your next auto lease.
    </p>
</section>
<div class="content">
    <div class="search-widget">
        <form method="post" id="filter_form">
            <div class="container">
                <h2 style="color: #3d5dcd;">
                    Search For Cars
                </h2>
                <div class="filter-and-sort row">
                    <div class="filter col-md-8">
                        <div class="row">
                            <div class="col-md-6 form-group">

                                <select class="brand form-control" id="brand" name="brand">
                                    <option value="">Vehicle Make</option>
                                    <option value="Acura">Acura</option>
                                    <option value="Audi">Audi</option>
                                    <option value="BMW">BMW</option>
                                    <option value="Buick">Buick</option>
                                    <option value="Cadillac">Cadillac</option>
                                    <option value="Chevrolet">Chevrolet</option>
                                    <option value="Chrysler">Chrysler</option>
                                    <option value="Dodge">Dodge</option>
                                    <option value="Fiat">Fiat</option>
                                    <option value="Ford">Ford</option>
                                    <option value="GMC">GMC</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Infiniti">Infiniti</option>
                                    <option value="Jaguar">Jaguar</option>
                                    <option value="Jeep">Jeep</option>
                                    <option value="KIA">KIA</option>
                                    <option value="Land-Rover">Land Rover</option>
                                    <option value="Lexus">Lexus</option>
                                    <option value="Lincoln">Lincoln</option>
                                    <option value="Mazda">Mazda</option>
                                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                                    <option value="Mitsubishi">Mitsubishi</option>
                                    <option value="Nissan">Nissan</option>
                                    <option value="Porsche">Porsche</option>
                                    <option value="Scion">Scion</option>
                                    <option value="Subaru">Subaru</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Volkswagen">Volkswagen</option>
                                    <option value="Volvo">Volvo</option>
                                </select>

                            </div>
                            <div class="col-md-6 form-group">
                                <select class="model form-control" id="model" name="model">
                                    <option value="">Vehicle Model</option>
                                    <optgroup label="Acura">Acura
                                        <option value="Acura-MDX"> MDX</option>
                                        <option value="Acura-TSX">TSX</option>
                                        <option value="Acura-TSX-Sport"> TSX Sport</option>
                                        <option value="Acura-ZDX"> ZDX</option>
                                    </optgroup>
                                    <optgroup label="Buick">Buick
                                        <option value="Buick-Enclave">Enclave</option>
                                        <option value="Buick-Encore">Encore</option>
                                        <option value="Buick-Lacrosse">Lacrosse</option>
                                        <option value="Buick-Regal">Regal</option>
                                        <option value="Buick-Verano">Verano</option>
                                    </optgroup>
                                    <optgroup label="Chrysler">Chrysler
                                        <option value="Chrysler-200">200</option>
                                        <option value="Chrysler-200-Convertible">200 Convertible</option>
                                        <option value="Chrysler-300">300</option>
                                        <option value="Chrysler-Town-and-Country">Town and Country</option>
                                    </optgroup>
                                    <optgroup label="Ford">Ford
                                        <option value="Ford-Edge">Edge</option>
                                        <option value="Ford-Expedition">Expedition</option>
                                        <option value="Ford-F150">F150</option>
                                        <option value="Ford-Fusion-SE-Hybrid">Fusion SE Hybrid</option>
                                        <option value="Ford-Taurus">Taurus</option>
                                    </optgroup>
                                    <optgroup label="Hyundai">Hyundai
                                        <option value="Hyundai-Azera">Azera</option>
                                        <option value="Hyundai-Equus">Equus</option>
                                        <option value="Hyundai-Santa-Fe">Santa Fe</option>
                                        <option value="Hyundai-Sonata">Sonata</option>
                                    </optgroup>
                                    <optgroup label="Jeep">Jeep
                                        <option value="Jeep-Compass">Compass</option>
                                        <option value="Jeep-Grand-Cherokee">Grand Cherokee</option>
                                        <option value="Jeep-Patriot">Patriot</option>
                                        <option value="Jeep-Wrangler">Wrangler</option>
                                    </optgroup>
                                    <optgroup label="Lexus">Lexus
                                        <option value="Lexus-C">C</option>
                                        <option value="Lexus-ES350">ES350</option>
                                        <option value="Lexus-LS-Hybrid">LS Hybrid</option>
                                        <option value="Lexus-LX">LX</option>
                                        <option value="Lexus-RX-350">RX 350</option>
                                    </optgroup>
                                    <optgroup label="Mercedes-Benz">Mercedes-Benz
                                        <option value="Mercedes-Benz-C-Class">C Class</option>
                                        <option value="Mercedes-Benz-E-Class">E Class</option>
                                        <option value="Mercedes-Benz-M-Class">M Class</option>
                                        <option value="Mercedes-Benz-S-Class">S Class</option>
                                        <option value="Mercedes-Benz-SLK-Class">SLK Class</option>
                                    </optgroup>
                                    <optgroup label="Porsche">Porsche
                                        <option value="Porsche-911">911</option>
                                        <option value="Porsche-Boxster">Boxster</option>
                                        <option value="Porsche-Cayenne">Cayenne</option>
                                        <option value="Porsche-Cayman">Cayman</option>
                                        <option value="Porsche-Panamera">Panamera</option>
                                    </optgroup>
                                    <optgroup label="Toyota">Toyota
                                        <option value="Toyota-4Runner">4Runner</option>
                                        <option value="Toyota-Camry">Camry</option>
                                        <option value="Toyota-Highlander">Highlander</option>
                                        <option value="Toyota-Sequoia">Sequoia</option>
                                        <option value="Toyota-Tacoma">Tacoma</option>
                                        <option value="Toyota-Tundra">Tundra</option>
                                    </optgroup>
                                    <optgroup label="Audi">Audi
                                        <option value="Audi-A4">A4</option>
                                        <option value="Audi-Q5">Q5</option>
                                        <option value="Audi-Q5-Coupe">Q5 Coupe</option>
                                        <option value="Audi-TT">TT</option>
                                        <option value="Audi-S7">S7</option>
                                    </optgroup>
                                    <optgroup label="Cadillac">Cadillac
                                        <option value="Cadillac-ATS">ATS</option>
                                        <option value="Cadillac-CTS">CTS</option>
                                        <option value="Cadillac-Escalade">Escalade</option>
                                        <option value="Cadillac-SRX">SRX</option>
                                        <option value="Cadillac-XTS">XTS</option>
                                    </optgroup>
                                    <optgroup label="Dodge">Dodge
                                        <option value="Dodge-Charger">Charger</option>
                                        <option value="Dodge-Dart">Dart</option>
                                        <option value="Dodge-Durango">Durango</option>
                                        <option value="Dodge-Journey">Journey</option>
                                        <option value="Dodge-RAM-1500">RAM 1500</option>
                                    </optgroup>
                                    <optgroup label="GMC">GMC
                                        <option value="GMC-Acadia">Acadia</option>
                                        <option value="GMC-Sierra">Sierra</option>
                                        <option value="GMC-Terrain">Terrain</option>
                                        <option value="GMC-Yukon">Yukon</option>
                                        <option value="GMC-Yukon-XL">Yukon XL</option>
                                    </optgroup>
                                    <optgroup label="Infiniti">Infiniti
                                        <option value="Infiniti-G">G</option>
                                        <option value="Infiniti-IPL-G">IPL G</option>
                                        <option value="Infiniti-M">M</option>
                                        <option value="Infiniti-QX">QX</option>
                                    </optgroup>
                                    <optgroup label="KIA">KIA
                                        <option value="KIA-Cadenza">Cadenza</option>
                                        <option value="KIA-Optima">Optima</option>
                                        <option value="KIA-Sedona">Sedona</option>
                                        <option value="KIA-Sorento">Sorento</option>
                                        <option value="KIA-Sportage">Sportage</option>
                                    </optgroup>
                                    <optgroup label="Lincoln">Lincoln
                                        <option value="Lincoln-MKS">MKS</option>
                                        <option value="Lincoln-MKT">MKT</option>
                                    </optgroup>
                                    <optgroup label="Mitsubishi">Mitsubishi
                                        <option value="Mitsubishi-Lancer">Lancer</option>
                                        <option value="Mitsubishi-Outlander">Outlander</option>
                                    </optgroup>
                                    <optgroup label="Scion">Scion
                                        <option value="Scion-FR-S">FR S</option>
                                        <option value="Scion-TC">TC</option>
                                        <option value="Scion-XB">XB</option>
                                        <option value="Scion-XD">XD</option>
                                    </optgroup>
                                    <optgroup label="Volkswagen">Volkswagen
                                        <option value="Volkswagen-Jetta">Jetta</option>
                                        <option value="Volkswagen-3-Series">3 Series</option>
                                        <option value="Volkswagen-5-Series">5 Series</option>
                                        <option value="Volkswagen-M-Series">M Series</option>
                                        <option value="Volkswagen-X5-Series">X5 Series</option>
                                        <option value="Volkswagen-X6-Series">X6 Series</option>
                                    </optgroup>
                                    <optgroup label="Chevrolet">Chevrolet
                                        <option value="Chevrolet-Camaro">Camaro</option>
                                        <option value="Chevrolet-Silverado">Silverado</option>
                                        <option value="Chevrolet-Suburban">Suburban</option>
                                        <option value="Chevrolet-Tahoe">Tahoe</option>
                                        <option value="Chevrolet-Traverse">Traverse</option>
                                    </optgroup>
                                    <optgroup label="FIAT">FIAT
                                        <option value="FIAT-Abarth">Abarth</option>
                                        <option value="FIAT-Cabrio">Cabrio</option>
                                        <option value="FIAT-E">E</option>
                                        <option value="FIAT-L">L</option>
                                    </optgroup>
                                    <optgroup label="Honda">Honda
                                        <option value="Honda-Accord">Accord</option>
                                        <option value="Honda-Civic">Civic</option>
                                        <option value="Honda-CRV">CRV</option>
                                        <option value="Honda-Odyssey">Odyssey</option>
                                        <option value="Honda-Pilot">Pilot</option>
                                    </optgroup>
                                    <optgroup label="Jaguar">Jaguar
                                        <option value="Jaguar-F-Type">F Type</option>
                                        <option value="Jaguar-XF">XF</option>
                                        <option value="Jaguar-XJ">XJ</option>
                                        <option value="Jaguar-XK">XK</option>
                                    </optgroup>
                                    <optgroup label="Land Rover">Land Rover
                                        <option value="Land-Rover-LR4">LR4</option>
                                        <option value="Land-Rover-Range-Rover">Range Rover</option>
                                        <option value="Land-Rover-Range-Rover-Evoque">Range Rover Evoque</option>
                                        <option value="Land-Rover-Range-Rover-HSE">Range Rover HSE</option>
                                        <option value="Land-Rover-Range-Rover-Sport">Range Rover Sport</option>
                                    </optgroup>
                                    <optgroup label="Mazda">Mazda
                                        <option value="Mazda-CX-5">CX 5</option>
                                        <option value="Mazda-CX-7">CX 7</option>
                                        <option value="Mazda-CX-9">CX 9</option>
                                        <option value="Mazda-MX-5-Miata">MX 5 Miata</option>
                                    </optgroup>
                                    <optgroup label="Nissan"> Nissan
                                        <option value="Nissan-Altima">Altima</option>
                                        <option value="Nissan-Armada">Armada</option>
                                        <option value="Nissan-Maxima">Maxima</option>
                                        <option value="Nissan-Murano">Murano</option>
                                        <option value="Nissan-Pathfinder">Pathfinder</option>
                                        <option value="Nissan-Rogue">Rogue</option>
                                    </optgroup>
                                    <optgroup label="Subaru">Subaru
                                        <option value="Subaru-BRZ">BRZ</option>
                                        <option value="Subaru-Forester">Forester</option>
                                        <option value="Subaru-Legacy">Legacy</option>
                                        <option value="Subaru-Outback">Outback</option>
                                        <option value="Subaru-Tribeca">Tribeca</option>
                                    </optgroup>
                                    <optgroup label="Volvo">Volvo
                                        <option value="Volvo-C30">C30</option>
                                        <option value="Volvo-C70">C70</option>
                                        <option value="Volvo-S-Series">S Series</option>
                                        <option value="Volvo-XC60">XC60</option>
                                        <option value="Volvo-XC90">XC90</option>
                                    </optgroup>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn green">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="marg-lg-b20 marg-md-b20 marg-xs-b20"></div>
    <div class="container">
        <?php if (isset($posts)) { ?>
            <div>
                <h3 class="num-villa" style="color: black;"><?php echo $total_post; ?> VEHICLES FOUND</h3>
            </div>
            <div class="marg-lg-b20 marg-md-b20 marg-xs-b20"></div>
            <div class="row blog-roll__post">
                <?php
                if (isset($posts) && $posts->have_posts()) {

                    while ($posts->have_posts()) {
                        $posts->the_post();
                        ?>
                        <div class="recent-post container">
                            <div class="row post_data">
                                <div class="col-md-4">
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="drop-shadow-bg"><?php the_post_thumbnail(); ?></a>
                                </div>
                                <div class="card">
                                    <div class="col-md-8"><h3 style="color: black;"><a href="<?php echo esc_url(get_the_permalink()); ?>" class=""><?php the_title(); ?></a></h3>
                                        <p class="vil-detail" style="color: black;">Brand: <strong><?php the_field('vehicle_make'); ?></strong></p>
                                        <p class="bedsize" style="color: black;">Model: <strong><?php the_field('vehicle_model'); ?></strong></p>
                                    </div>
                                </div>
                            </div>
                            <br /> <br />
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>


</div>
<?php
get_footer();
?>