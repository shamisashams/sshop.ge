<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="s.css">
    <title>Sshop Warranty</title>


    <style>

        @font-face {

        }

      body {
        background-color: #f1f1f1;
          font-family: Trickster;
      }
      .wrapper {
        width: 1000px;
        margin: auto;
        padding: 30px 0;
      }
      .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .heading div {
        max-width: 150px;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.116);
      }
      .title {
        text-align: center;
        margin-bottom: 40px;
      }
      .box {
        /* border: 1px solid rgba(0, 0, 0, 0.171); */
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.116);
      }
      .desc {
        max-width: 500px;
        margin: auto;
        margin-right: 0;
        margin-top: 40px;
      }
      .signiture {
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        margin: 40px 0;
      }
      .signiture p {
        padding-top: 30px;
        width: fit-content;
        border-top: 1px solid rgba(0, 0, 0, 0.342);
        margin-left: 100px;
      }
      @media screen and (max-width: 1200px) {
        .wrapper {
          width: 90%;
        }
      }
    </style>
  </head>
  <body>
  @inject('product_m','App\Models\Product')
  <?php
  $product = $product_m->find($item->product_id)
  ?>
    <div class="wrapper">
      <div class="heading">
       {{-- <div>ადილი ჩეკის მისამაგრებლად</div>--}}
        <img src="logo.png" alt="" />
      </div>
      <div class="title">
        <h1>საგარანტიო ტალონი</h1>
        <h4>საქართველო</h4>
      </div>
      <div class="box">მოდელი: {{$item->name}}</div>
      <div class="box">
        сериал: {{$product->model}}
      </div>
      <div class="box">date: {{$order->created_at}}</div>

      <h4>გამყიდველი:</h4>
      <div class="box">სავაჭრო ორგანიზაციის დასახელება: შპს „ShokSkop2022”</div>
      <div class="box">საჭირო ორგანიზაციის ტელეფონი: (032) 2 200 202</div>
      <div class="box">მისამართი: თბილისი, აწყურის ქ.# 45 ა.</div>
      <div class="box">საგარანტიო პერიოდი: 2 წელი</div>
      <h4 class="desc" style="text-align: right">
        მოწყობილობა მიღებულია მუშა მდგომარეობაში. <br />
        საგარანტიო პირობებს გავეცანი და ვეთანხმები. <br />
        ვიღებ ვალდებულებას მივყვე მოთხოვნებს, რომლებიც წარმოდგენილია
        ექსპლუატაციის ინსტრუქციაში და საგარანტიო ტალონში.
      </h4>
      <div class="signiture">
        <p>მყიდველის ხელმოწერა</p>
        <p>მყიდველის სახელი და გვარი</p>
      </div>
      <div class="box">
        <strong>ყურადღება! მოითხოვეთ საგარანტიო ტალონის შევსება!</strong>
        <p>
          საგარანტიო ტალონი არ მოქმედებს თუ არასწორად ან არასრულად არის
          შევსებული,გამყიდველის ბეჭდის და მყიდველის ხელმოწერის გარეშე.სალაროს
          ჩეკი აუცილებლად უნდა იყოს მიმაგრებული აღნიშნულ საგარანტიო ტალონზე.
        </p>
      </div>
    </div>
  </body>
</html>
