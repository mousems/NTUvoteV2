<!DOCTYPE html>
<html class='han-la' lang='zh-tw'>
  <head>
    <meta charset='utf-8'>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>NTU Voting</title>
    <link href="<?=base_url('assets/css/all.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?=base_url('assets/js/modernizr.js');?>" type="text/javascript"></script>
  </head>
  <body class='multiple_selection'>
    <form action="" accept-charset="UTF-8" class="multiple-selection-form" method="post"><input name="skipped" class="skipped" style="display: none;" type="text" />
    <div class='header'>
      <hgroup class='title'>
        <h1>NTU Voting</h1>
        <h2>○: 同意，✕: 不同意，-: 沒意見。</h2>
      </hgroup>
      <div class='actions two-actions'>
        <button class='button skip'>Skip</button>
        <input value="Submit" class="action button" type="submit" />
      </div>
    </div>
    <div class='main' id='main'>
      <div class='votes'>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>1</div>
            <div class='choices'>
              <input name="opinion_to_1" class="agree" value="1" type="radio" />
              <input name="opinion_to_1" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_1" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/355x302/d16824/51abdf)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>2</div>
            <div class='choices'>
              <input name="opinion_to_2" class="agree" value="1" type="radio" />
              <input name="opinion_to_2" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_2" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/260x262/1659af/50bca8)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>3</div>
            <div class='choices'>
              <input name="opinion_to_3" class="agree" value="1" type="radio" />
              <input name="opinion_to_3" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_3" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/314x313/257b36/96d3a2)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>4</div>
            <div class='choices'>
              <input name="opinion_to_4" class="agree" value="1" type="radio" />
              <input name="opinion_to_4" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_4" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/221x381/7b38ca/8f0eba)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>5</div>
            <div class='choices'>
              <input name="opinion_to_5" class="agree" value="1" type="radio" />
              <input name="opinion_to_5" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_5" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/303x302/e28975/ed1a3c)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>6</div>
            <div class='choices'>
              <input name="opinion_to_6" class="agree" value="1" type="radio" />
              <input name="opinion_to_6" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_6" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/226x215/a209e8/0eb4a1)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>7</div>
            <div class='choices'>
              <input name="opinion_to_7" class="agree" value="1" type="radio" />
              <input name="opinion_to_7" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_7" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/260x346/13be72/016ed2)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>8</div>
            <div class='choices'>
              <input name="opinion_to_8" class="agree" value="1" type="radio" />
              <input name="opinion_to_8" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_8" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/204x284/5c6f9b/067fb9)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>9</div>
            <div class='choices'>
              <input name="opinion_to_9" class="agree" value="1" type="radio" />
              <input name="opinion_to_9" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_9" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/320x308/346981/026f84)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>10</div>
            <div class='choices'>
              <input name="opinion_to_10" class="agree" value="1" type="radio" />
              <input name="opinion_to_10" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_10" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/319x333/d73812/630dc8)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>11</div>
            <div class='choices'>
              <input name="opinion_to_11" class="agree" value="1" type="radio" />
              <input name="opinion_to_11" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_11" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/358x235/f853b1/27361f)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>12</div>
            <div class='choices'>
              <input name="opinion_to_12" class="agree" value="1" type="radio" />
              <input name="opinion_to_12" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_12" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/288x352/5ed67a/be25fa)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>13</div>
            <div class='choices'>
              <input name="opinion_to_13" class="agree" value="1" type="radio" />
              <input name="opinion_to_13" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_13" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/365x222/1c6d38/6128c4)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>14</div>
            <div class='choices'>
              <input name="opinion_to_14" class="agree" value="1" type="radio" />
              <input name="opinion_to_14" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_14" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/252x346/25c9ab/7e310b)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>15</div>
            <div class='choices'>
              <input name="opinion_to_15" class="agree" value="1" type="radio" />
              <input name="opinion_to_15" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_15" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/211x304/3cd829/093ce5)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>16</div>
            <div class='choices'>
              <input name="opinion_to_16" class="agree" value="1" type="radio" />
              <input name="opinion_to_16" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_16" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/398x272/48f591/0b6da7)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>17</div>
            <div class='choices'>
              <input name="opinion_to_17" class="agree" value="1" type="radio" />
              <input name="opinion_to_17" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_17" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/374x256/c302f7/2f17cd)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>18</div>
            <div class='choices'>
              <input name="opinion_to_18" class="agree" value="1" type="radio" />
              <input name="opinion_to_18" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_18" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/399x235/120435/ace258)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>19</div>
            <div class='choices'>
              <input name="opinion_to_19" class="agree" value="1" type="radio" />
              <input name="opinion_to_19" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_19" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/266x317/dec63a/a764c0)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
        <div class='vote'>
          <div class='candidate'>
            <div class='id'>20</div>
            <div class='choices'>
              <input name="opinion_to_20" class="agree" value="1" type="radio" />
              <input name="opinion_to_20" class="none" value="0" checked="checked" type="radio" />
              <input name="opinion_to_20" class="disagree" value="-1" type="radio" />
            </div>
            <div class='pic'>
              <div class='img' style='background-image: url(http://placehold.it/391x344/e2a9d8/1acd67)'></div>
            </div>
            <div class='name'>◎◎◎</div>
          </div>
        </div>
      </div>
    </div>
    </form>
        <script src="<?=base_url('assets/js/all.js');?>" type="text/javascript"></script>
  </body>
</html>