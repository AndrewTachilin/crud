<!DOCTYPE html>
<html lang="en">
<body>

<main class="statistic-tmpl main">

    <section class="maincontent-statistic">
        <div class="statistic-container">
            <div class="title">
                <h1 class="title__item">Statistics</h1>
            </div>
            <label for="country" class="select-wrap">
                <select class="country_choice" name="country" id="country">
                    <option>Nigeria</option>
                    <option>Egypt</option>
                </select>
            </label>
            <table class="statistic-table">
                <tr class="statistic-table__title">
                    <td class="countries"><a href="">countries</a><label>50 000</label></td>
                    <td><a href="">registrations</a><label>50 000</label></td>
                    <td><a href="">free</a><label>50 000</label></td>
                    <!-- <td><a href="">free_plus</a><label>50 000</label></td> -->
                    <td><a href="">premium</a><label>50 000</label></td>
                    <td><a href="">professional</a><label>50 000</label></td>
                    <td><a href="">downloads</a><label>50 000</label></td>
                </tr>

                <?php
                $free =0;
                // $free_plus=0;
                $premium=0;
                $professional=0;
                ?>
                <?php foreach ($countries as $country) : ?>
                        <tr class="background-row">
                            <td class="background-row__item"><p class=""><?php echo $country->en; ?></p></td>
                            <?php
                                if(!empty($country->profit)){
                                        foreach ($country->profit as $profit) {
                                          if($profit->subscribe_type == 'free_plus'){
                                                $free_plus += $profit->price;
                                          }if($profit->subscribe_type == 'free'){
                                                $free += $profit->price;
                                          }if($profit->subscribe_type == 'premium'){
                                                $premium += $profit->price;
                                          }if($profit->subscribe_type == 'professional'){
                                                $professional += $profit->price;
                                          }
                                    }
                                } ?>
                                        <td class="background-row__item"><?php echo count($country->userCount); ?> </td>
                                        <td class="background-row__item"><?php echo $free; ?> </td>
                                        <!-- <td class="background-row__item"><php echo $free_plus; ?> </td> -->
                                        <td class="background-row__item"><?php echo $premium; ?> </td>
                                        <td class="background-row__item"><?php echo $professional; ?> </td>
                                        <td class="background-row__item"> 0 - is empty field now </td>

                        </tr>
                    <?php
                endforeach;
                    ?>
                <tr class="background-row">
                    <td class="background-row__item"><p href="" class="active-link">All countries</p></td>
                    <td class="background-row__item"><?php echo $totalUser ?></td>
                    <td class="background-row__item"><?php echo $counterFree ?></td>
                    <!-- <td class="background-row__item"><php echo $counterFree_plus ?></td> -->
                    <td class="background-row__item"><?php echo $counterPremium ?></td>
                    <td class="background-row__item"><?php echo $counterProfessional ?></td>
                    <td class="background-row__item">total</td>
                </tr>




            </table>
            
        </div>
    </section>
</main>
<script src="js/app.js"></script>
</body>
</html>