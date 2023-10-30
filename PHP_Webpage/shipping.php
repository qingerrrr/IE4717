<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Unoguerta</title>
    <!-- styles -->
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="../CSS/responsive.css" />
  </head>

    <?php
        session_start();
    ?>

  <body>
    <div class="shipping">
      <div class="container">
        <div class="custom_row">
          <div class="column_6">
            <form class="shipping_form">
              <h5>Contact Information</h5>
              <div class="email_group">
                <input type="email" class="input_box" placeholder="Email" />
              </div>
              <h5>Shipping To</h5>
              <div>
                <input
                  type="text"
                  class="input_box"
                  placeholder="Country/Region"
                />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Name" />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Phone" />
              </div>
              <div>
                <input type="text" class="input_box" placeholder="Address" />
              </div>
              <div>
                <input
                  type="text"
                  class="input_box"
                  placeholder="Postal Code"
                />
              </div>
              <button type="submit" class="btn_submit">Ready to Ship</button>
            </form>
          </div>
          <div class="column_6">
            <table class="table tbale_shipping">
              <h5 class="ms-2">Your Basket</h5>
              <tbody>
                <tr>
                  <td>Book Name 1</td>
                  <td>1</td>
                  <td class="text-last">
                    $<span class="item-total">10.00</span>
                  </td>
                </tr>
                <tr>
                  <td>Book Name 2</td>
                  <td>1</td>
                  <td class="text-last">
                    $<span class="item-total">10.20</span>
                  </td>
                </tr>
                <tr>
                  <td>Book Name 3</td>
                  <td>3</td>
                  <td class="text-last">
                    $<span class="item-total">30.00</span>
                  </td>
                </tr>
                <tr class="border-top">
                  <td colspan="3" class="text-last text_total">
                    Total Cost $<span id="basketTotal"></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <!-- <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/custom.js"></script> -->
  </body>


</html>
