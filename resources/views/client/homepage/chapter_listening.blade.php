@extends('client/homepage.layouts.app')

@section('additional-style')
<style>
    @media (min-width: 1200px){
    .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1300px;
    }
  }
  .btn2top .sticky-btn {
    position: fixed;
    bottom: 36px;
    right: 60px;
    background: dodgerblue;
    opacity: .6;
    border-radius: 50%;
    transition: all 0.9s ease;
  }
  .btn2top .sticky-btn img {
    width: 36px;
    height: 36px;
  }
  
  .btn2top a.sticky-btn {
    font-family: sans-serif;
    padding: 9px;
    display: block;
    transition: all 0.3s ease;
    color: #fff;
    text-decoration: none;
  }
  .btn2top a.sticky-btn:hover {
    color: yellow;
    cursor: pointer;
  }
  
  
  @media screen and (max-width: 768px) {
    .btn2top .sticky-btn {
      right: 21px;
      bottom: 21px;
  
    }  
  
  }
  
  .btn2test{
    position: fixed;
    top: 120px;
    right: 60px;
    transition: all 0.9s ease;
    padding: 5px;
  }

  
  .btn2test button:nth-child(odd){
      margin:10px 0 10px 0;
  }
  
  
  @media screen and (max-width: 768px) {
    .btn2test {
      right: 21px;
      /* top: 21px; */
  
    }  
  
  }

  
  
  .btn2contact .sticky-btn {
    position: fixed;
    bottom: -96px;
    left: 33px;
    background: #F9FBE7;
    padding: 12px;
    border-radius: 50%;
    transition: all 0.8s ease;
    bottom: 36px;
  
  }
  .btn2contact .sticky-btn:hover {
    cursor: pointer;
  
    background: rgba(255, 255, 255, 0.81);
    transform: translateY(-3px);
  }
  .btn2contact .sticky-btn img {
    width: 45px;
  
  }
  
  


  @media screen and (max-width: 768px) {
    .btn2contact .sticky-btn {
      bottom: 21px;
  
      left: 21px;
    } 
    .btn2contact .sticky-btn img {
      width: 36px;
    }
    
  }
   
  .nk-content{
    background-color:#e5e5e5 !important;
  }
  </style>
@endsection
@section('content')
<div>
 
  <div class="nk-block" id="content-box-detail">
    <div class="container">
      
      
    <div class="card card-bordered">
        <div class="">
          <div class="d-flex justify-content-between">
              <div class="p-2 ">
                  @if($previous)
                  <a href="{{ $previous->slug }}" class="btn btn-lg btn-outline-secondary">
                    <em class="icon ni ni-arrow-long-left"></em>
                    <span>Chương trước</span>
                    </a>
                  @else
                  <button class="btn btn-lg  btn-outline-secondary" disabled>
                    <em class="icon ni ni-arrow-long-left"></em>
                    <span>Chương trước</span>
            
                  </button>
                  @endif
              </div>
        
              <div class="p-2">
                <a href="/doc-sach/{{ $chapter->books->slug }}/{{  $chapter->slug }}" class="btn btn-lg btn-outline-secondary" >
                    <em class="icon ni ni-book-read"></em><span>Sách đọc</span>
                </a>
              </div>
            <div class="p-2">
            
              @if($next)
              <a href="{{ $next->slug }}" class="btn btn-lg btn-outline-secondary">
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
        
              </a>
              @else
              <button class="btn btn-lg  btn-outline-secondary" disabled>
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
              </button>
              @endif
            </div>
          </div>
        </div>
      
        <div class="card-inner">

        
        
        <div class="title mb-2">
            @if($chapter->name)
            <h3 class="text-left">       
            {{$chapter->code}}: {{ $chapter->name }}
            </h3>
            @else
            <h3 class="text-left">       
                {{$chapter->code}}
            </h3>
            @endif 
        </div>

        <div class="d-flex bg-light">
            <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-book"></em>
                <a class="text-dark" href="/sach/{{$chapter->books->id  }}/{{ $chapter->books->slug  }}">{{ $chapter->books->name }}</a>
            </div>
            <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-edit"></em>          
                <a class="text-dark" href="/thanh-vien/{{ $chapter->books->users->id }}">{{ $chapter->books->users->profile->displayName }}</a>
            </div>
            <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-text"></em>
                <span>{{ $chapter->numberOfWords }} chữ</span>
            </div>
            <div class="p-2 flex-fill bg-light">
                <em class="icon ni ni-clock"></em>          
                <span>{{ $chapter->updated_at }}</span>
            </div>
            <div class="p-2 flex-fll bg-light">
              <button class="btn btn-sm btn-icon btn-outline-secondary edit-chapter-button"><em class="icon ni ni-edit"></em></button>

          </div>
            
        </div>
        <div class="border px-2" style="font-size: 16px;line-height:3; white-space: break-spaces;" id="text" >
    
        
            {{ $content }} 

        </div>   

        
        </div>
    </div>
        
    <div class="card card-bordered rounded">
      <div class="">
          <div class="d-flex justify-content-between">
              <div class="p-2 ">
                  @if($previous)
                  <a href="{{ $previous->slug }}" class="btn btn-lg btn-outline-secondary">
                    <em class="icon ni ni-arrow-long-left"></em>
                    <span>Chương trước</span>
                    </a>
                  @else
                  <button class="btn btn-lg  btn-outline-secondary" disabled>
                    <em class="icon ni ni-arrow-long-left"></em>
                    <span>Chương trước</span>
            
                  </button>
                  @endif
              </div>
        
              <div id="report-render-div" class="d-flex align-items-center">
                @if(Auth::check())
        
                @if($reportChapter)
                    @if($reportChapter->isEnabled)
                        <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportForm">
                            <em class="icon ni ni-flag" ></em>
                        </button>
                    @else

                    <dfn data-info="Đã có người báo cáo">
                        <button type="button" class="btn btn-lg btn-outline-secondary" disabled>
                            <em class="icon ni ni-flag"></em>
                        </button>
                    </dfn>
                    
                    @endif
                @else
                    <button type="button" class="btn btn-lg btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportForm">
                        <em class="icon ni ni-flag" ></em>
                    </button>
                @endif
            
            
            @endif
        </div>
            <div class="p-2">
            
              @if($next)
              <a href="{{ $next->slug }}" class="btn btn-lg btn-outline-secondary">
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
        
              </a>
              @else
              <button class="btn btn-lg  btn-outline-secondary" disabled>
                <span>Chương sau</span>
                <em class="icon ni ni-arrow-long-right"></em>
        
              </button>
              @endif
            </div>
          </div>
      </div>
    </div>
  
        
    
    </div>
  
    <div class="btn2top">
        <a class="sticky-btn">
        <img src="https://byjaris.com/code/icons/chevron-up.svg">
        </a>
    </div>
  
  
    <div class="btn2contact">
      <a target="blank" class="toggle sticky-btn" data-target="addProduct"> 
        <img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/svg/config.png">
      </a>
    </div>

    <div class="btn2test btn btn-lg btn-secondary">
      <div class="d-flex flex-column">
        <button class="flex-fill btn btn-icon btn-lg btn-outline-success" id="play-button">
            <em class="icon ni ni-play m-auto"></em>
        </button>
        <button class="flex-fill btn btn-icon btn-lg btn-outline-danger" id="pause-button">
            <em class="icon ni ni-pause m-auto"></em>
        </button>
        <button class="flex-fill btn btn-icon btn-lg btn-outline-warning" id="stop-button">
            <em class="icon ni ni-stop m-auto"></em>
        </button>
      </div>
    </div>



  </div>

  <div class="nk-add-product toggle-slide toggle-slide-right toggle-screen-any" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">
      <div class="nk-block-head">
          <div class="nk-block-head-content">
            <div class="form-group">
              <label class="form-label" for="product-title">Danh sách chương</label>
              <div class="form-control-wrap">
                <select class="form-control" id="change-chapter">
                  @foreach ($chapters as $item)
                  <option value="{{ $item->slug }}" {{ $item->id == $chapter->id ? 'selected' : '' }}>
                    
                      <span>{{$item->code}}</span>
                       
                  </option>
                  @endforeach
                </select>
              </div>
          </div>
               
          <h5 class="nk-block-title">Cài đặt hiển thị</h5>

          </div>
      </div><!-- .nk-block-head -->
      <div class="nk-block">
          <div class="row g-3">
              <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="product-title">
                        <span>Giọng nói
                        </span>
                        <em class="icon ni ni-mic"></em>
                        </label>
                      <div class="form-control-wrap">
                        <select id="voice"></select>
                      </div>
                  </div>
              </div>
              {{-- <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="regular-price">Tương tác</label>
                      <div class="d-flex">
                        <button class="flex-fill btn btn-icon btn-lg btn-outline-success" id="play-button">
                            <em class="icon ni ni-play m-auto"></em>
                        </button>
                        <button class="flex-fill btn btn-icon btn-lg btn-outline-danger" id="pause-button">
                            <em class="icon ni ni-pause m-auto"></em>
                        </button>
                        <button class="flex-fill btn btn-icon btn-lg btn-outline-warning" id="stop-button">
                            <em class="icon ni ni-stop m-auto"></em>
                        </button>
                      </div>
                  </div>
              </div> --}}
              <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="sale-price">
                        <span>Độ cao giọng
                        </span>
                        <em class="icon ni ni-line-chart-up"></em>
                        </label>
                      </label>
                      <div class="form-control-wrap">
                        <input id="pitch" type="range" min="0.1" max="2" step="0.1" value="1" class="form-range">
                        <output for="pitch">1</output>
                      </div>
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="stock">
                        <span>Tốc độ
                        </span>
                        <em class="icon ni ni-forward"></em>
                        </label>
                      </label>
                      <div class="form-control-wrap">
                        <input id="rate" type="range" min="0.1" max="2" step="0.1" value="1" class="form-range">
                        <output for="rate">1</output>
                      </div>
                  </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="stock">
                        <span>Âm lượng
                        </span>
                        <em class="icon ni ni-vol"></em>
                        </label>
                    </label>
                    <div class="form-control-wrap">
                        <input id="volume" type="range" min="0" max="2" step="0.1" value="1" class="form-range">
                        <output for="volume">1</output>
                    </div>
                </div>
            </div>
              <div class="col-12">
                  <button class="btn btn-primary" id="save-setting"><em class="icon ni ni-plus"></em><span>Lưu cài đặt</span></button>
              </div>
             
          </div>
      </div><!-- .nk-block -->
  </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 697px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 636px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
</div>



@section('modal')
@if(Auth::check())

<div class="modal fade" id="reportForm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo cáo chương</h5>
                <button id="close-btn" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" novalidate="novalidate">
                    @csrf
                    <input type="hidden" class="form-control" id="type_id" name="type_id" value=2>
                    <input type="hidden" class="form-control" id="identifier_id" name="identifier_id" value={{ $chapter->id }}>

                    <div class="form-group">
                        <label class="form-label" for="chapter-code">Tên chương</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="chapter-code" required="" value='{{ $chapter->code }}' readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reason">Lý do</label>
                        <div class="form-control-wrap">
                            <select required class="form-control mb-4 col-6" name="reason" id="reason">
                                @foreach ($reportReasons as $reason)
                                <option value="{{ $reason->id }}" >{{ $reason->name }}</option>
                                @endforeach
                            </select>                        
                        </div>                     
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Ghi chú</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-sm" id="description" name="description" placeholder="Lý do của bạn" required></textarea>
                        </div>
                      
                    </div>
                    <div class="form-group text-right">
                        <button id="report-btn" class="btn btn-lg btn-primary">Báo cáo</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text">Báo cáo bởi {{ Auth::user()->profile->displayName }}</span>
            </div>

        </div>
    </div>
</div>
@endif
@endsection
@endsection
@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment-with-locales.js"></script>

    <script>
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        const voiceList = document.querySelector("select");

        // grab the UI elements to work with
        const textEl = document.getElementById('text');

        const voiceInEl = document.getElementById('voice');

        const playButton = document.getElementById('play-button');
        const pauseButton = document.getElementById('pause-button');
        const stopButton = document.getElementById('stop-button');

        const pitchInEl = document.getElementById('pitch');
        const rateInEl = document.getElementById('rate');
        const volumeInEl = document.getElementById('volume');
        const pitchOutEl = document.querySelector('output[for="pitch"]');
        const rateOutEl = document.querySelector('output[for="rate"]');
        const volumeOutEl = document.querySelector('output[for="volume"]');

        // set text


      
        $(function(){

          $("option[value='Microsoft HoaiMy Online (Natural) - Vietnamese (Vietnam)']").text('Giọng nữ');
          $("option[value='Microsoft NamMinh Online (Natural) - Vietnamese (Vietnam)']").text('Giọng nam');
          
          $("#text").text( $.trim( $("#text").text() ));
          $('#change-chapter').select2({});

          $('.btn2top').on('click', function() {
          window.scrollTo({top: 0})
          });

            $(window).scroll(function(){
              var $this = $(window);


              if( $this.scrollTop() > ($('#text').height() - 300) ) { 
                $('.sticky-btn').hide();
                $('.btn2test').hide();

              }
              else{
                $('.sticky-btn').show();
                $('.btn2test').show();
              } 
            });

        

            const settingLog = window.localStorage.getItem('settingListening');


            if(setting){
                var setting = JSON.parse(settingLog);

                var voice = setting.voice;
                var pitch = parseFloat(setting.pitch);
                var speed = parseFloat(setting.speed);
                var volume = parseFloat(setting.volume);

                
              
                $(`#pitch`).val(pitch);
                $(`#rate`).val(speed);
                $(`#volume`).val(volume);

                pitchOutEl.textContent = setting.pitch;
                rateOutEl.textContent = setting.speed;
                volumeOutEl.textContent = setting.volume;
                
                $(`option[value='${voice}']`).attr('selected','selected');

                let utterance = new SpeechSynthesisUtterance(text);

                utterance.voice = window.speechSynthesis.getVoices().find(voice => voice.voiceURI === voiceInEl.value);
                utterance.pitch = pitchInEl.value;
                utterance.rate = rateInEl.value;
                utterance.volume = volumeInEl.value;

               
            }

          const current_book_id = {!! $chapter->books->id !!}
          var current_chapter_id =  {!! $chapter->id !!}

          var readingLog = window.localStorage.getItem('readingLog');

          var log = JSON.parse(readingLog);


          //update cookie
          if(log){             
          objIndex = log.findIndex((obj => obj.book_id === current_book_id));
          //book exist

          if(objIndex > -1){
            
                const now = moment().format('llll');
                var chapterList = log[objIndex].chapterList;



                var chapterIndex = chapterList.findIndex(e => e.chapter_id === current_chapter_id);

                if(chapterIndex > -1){
                    chapterList[chapterIndex].time = now;
                    window.localStorage.setItem('readingLog',JSON.stringify(log));
                }
                else{
                    const logObject = {
                        "chapter_id":current_chapter_id,
                        "time":now
                    }

                    const updateChapterList = [...chapterList,logObject]
                    log[objIndex].chapterList = updateChapterList;

                    window.localStorage.setItem('readingLog',JSON.stringify(log));
                }    
          }
          //book not exist
          else{

            const time = moment().format('llll');
            const logObject = {
                "chapter_id":current_chapter_id,
                "time":time
            }
            var chapterList = [];
            chapterList.push(logObject)

            var reading_object = {
                'book_id' : current_book_id,
                'chapterList' : chapterList        
            };            
       
            const updateLog = [...log,reading_object]
            window.localStorage.setItem('readingLog',JSON.stringify(updateLog));
          }        
      }
      //create new cookie
      else{

        const time = moment().format('llll');
        const logObject = {
            "chapter_id":current_chapter_id,
            "time":time
        }
        var chapterList = [];
        chapterList.push(logObject)
        var reading_object = {
        'book_id' : current_book_id,
        'chapterList' : chapterList        
        };            
        var reading_log = [];
        reading_log.push(reading_object);
        window.localStorage.setItem('readingLog',JSON.stringify(reading_log));

      }

        })

        $(document).on('change','#change-chapter',function(){ //2 step
            var chapter_slug = $(this).val();  
            $(location).prop('href', chapter_slug);
        });
        
       
        pauseButton.disabled = true;
        stopButton.disabled = true;
        window.speechSynthesis.cancel();
        // add UI event handlers


        pitchInEl.addEventListener('change', updateOutputs);
        rateInEl.addEventListener('change', updateOutputs);
        volumeInEl.addEventListener('change', updateOutputs);

        playButton.addEventListener('click', play);
        pauseButton.addEventListener('click', pause);
        stopButton.addEventListener('click', stop);


        // update voices immediately and whenever they are loaded

        function updateOutputs() {
        // display current values of all range inputs
        pitchOutEl.textContent = pitchInEl.value;
        rateOutEl.textContent = rateInEl.value;
        volumeOutEl.textContent = volumeInEl.value;
        }

        voices();
        function voices(){

            // 1 - VN | 0 - ENGLISH
            const language = {!! $chapter->books->language !!}

            var voices = null;
            if(language == 1){
               voices = window.speechSynthesis.getVoices().filter(function(item){            
                        return item.lang === "vi-VN";
                });
            }else{
              voices = window.speechSynthesis.getVoices().filter(function(item){            
                        return item.lang === "en-US";
                });
            }
         

            voices.forEach(voice => {
            const isAlreadyAdded = [...voiceInEl.options].some(option => option.value === voice.voiceURI);
            if (!isAlreadyAdded) {
            const option = new Option(voice.name, voice.voiceURI, voice.default, voice.default);
            voiceInEl.add(option);
                }
            });
            }
            window.speechSynthesis.addEventListener("voiceschanged",  voices)




        function play(){
              const text = textEl.textContent;

              if (window.speechSynthesis.speaking) {
              // there's an unfinished utterance
                  window.speechSynthesis.resume();
                  handleResume();
              } 
              // start new utterance
              else {
              let utterance = new SpeechSynthesisUtterance(text);

              utterance.voice = window.speechSynthesis.getVoices().find(voice => voice.voiceURI === voiceInEl.value);
              utterance.pitch = pitchInEl.value;
              utterance.rate = rateInEl.value;
              utterance.volume = volumeInEl.value;

              utterance.addEventListener('start', handleStart);

              utterance.addEventListener('end', handleEnd);
              utterance.addEventListener('boundary', handleBoundary);

              window.speechSynthesis.speak(utterance);
              }     
        }


        function pause() {
            window.speechSynthesis.pause();

            playButton.disabled = false;
            pauseButton.disabled = true;
            stopButton.disabled = false;
        }

        function stop() {
            window.speechSynthesis.cancel();

        // Safari doesn't fire the 'end' event when cancelling, so call handler manually
            handleEnd();
        }

        function handleStart() {

          if($('#text').text()){
            playButton.disabled = true;
            pauseButton.disabled = false;
            stopButton.disabled = false;
            voiceList.setAttribute("disabled", "disabled");
            $('#text').attr('contenteditable',false);

            $('.edit-chapter-button').attr('disabled',true);
          }
          else{
            handleEnd();
            Swal.fire({
                        icon: 'error',
                        title: `Lỗi văn bản`,
                        showConfirmButton: false,
                        timer: 2500
                    });
          }
        }



        function handleResume() {
            playButton.disabled = true;
            pauseButton.disabled = false;
            stopButton.disabled = false;
        }

        function handleEnd() {
            const text = textEl.textContent;

            playButton.disabled = false;
            pauseButton.disabled = true;
            stopButton.disabled = true;
            voiceList.removeAttribute("disabled", "disabled");
            $('.edit-chapter-button').removeAttr('disabled');

        // reset text to remove mark
            textEl.innerHTML = text;
        }

        function handleBoundary(event) {
        const text = textEl.textContent;

        if (event.name === 'sentence') {
            // we only care about word boundaries
            return;
        }

        const wordStart = event.charIndex;

        let wordLength = event.charLength;
        if (wordLength === undefined) {
            // Safari doesn't provide charLength, so fall back to a regex to find the current word and its length (probably misses some edge cases, but good enough for this demo)
            const match = text.substring(wordStart).match(/^[a-z\d']*/i);
            wordLength = match[0].length;
        }
        
        // wrap word in <mark> tag
        const wordEnd = wordStart + wordLength;
        const word = text.substring(wordStart, wordEnd);
        const markedText = text.substring(0, wordStart) + '<mark>' + word + '</mark>' + text.substring(wordEnd);
        textEl.innerHTML = markedText;
        }



      
        $('#save-setting').click(function(){
            window.localStorage.removeItem("settingListening");


            var setting ={
            'voice':window.speechSynthesis.getVoices().find(voice => voice.voiceURI === voiceInEl.value).voiceURI,
            'pitch':pitchInEl.value,
            'speed':rateInEl.value,
            'volume':volumeInEl.value
            }
            window.localStorage.setItem("settingListening", JSON.stringify(setting));
            Swal.fire({
                            icon: 'success',
                            title: `Lưu cài đặt thành công!!!`,
                            showConfirmButton: false,
                            timer: 2500
                })
            })
       
          
          $('.edit-chapter-button').click(function(){
              window.speechSynthesis.cancel();
              $('#text').attr('contenteditable',true);
              $('#text').focus();
          })  

            $('#text').focusout(function() {
              $('#text').attr('contenteditable',false);
          })
     

       

          $('#report-btn').click(function(e){

e.preventDefault();
Swal.fire({
    icon: 'info',
    html:
        'Tài khoản của bạn có thể bị <b>khóa</b> nếu bạn cố tình báo cáo sai',
    showCloseButton: true,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Báo cáo',
    cancelButtonText: `Không báo cáo`,
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {

        var form = $('#reportForm');

        var type_id = form.find('input[name="type_id"]').val();
        var identifier_id = form.find('input[name="identifier_id"]').val();
        var description = form.find('textarea[name="description"]').val();
        const reason = form.find('select[name="reason"]').val();

        if(description){
                $.ajax({
                url:'/bao-cao',
                type:"POST",
                data:{
                    'description': description,
                    'identifier_id':identifier_id,
                    'type_id':type_id,
                    'reason':reason
                }
                })
                .done(function(res) {
                
                    Swal.fire({
                            icon: 'success',
                            title: `${res.report}`,
                            showConfirmButton: false,
                            timer: 2500
                        });     

                    
                    setTimeout(()=>{
                        $('#close-btn').click();
                    }, 2500);
                    $("#report-render-div").load(" #report-render-div > *");

                    
                })

                .fail(function(jqXHR, textStatus, errorThrown) {
                // If fail
                console.log(textStatus + ': ' + errorThrown);
                })
        }
        else{
            Swal.fire('Vui lòng nhập lý do!!!', '', 'info')
        }

      



    } else if (result.isDenied) {
        Swal.fire('Báo cáo thất bại', '', 'info')
    }
})
})
    </script>
@endsection
