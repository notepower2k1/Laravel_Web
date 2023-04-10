@extends('client/layouts.app')

@section('additional-style')
@endsection
@section('content')
<div class="nk-content-body">
  <div class="nk-block-head nk-block-head-sm">
      <div class="nk-block-between">
          <div class="nk-block-head-content">
                  <div class="toggle-expand-content expanded" data-content="pageMenu" style="display: block;">
                      <ul class="nk-block-tools g-3">   
                          <li class="nk-block-tools-opt">
                              <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-setting"></em></a>
                              <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-setting"></em></a>
                             
                            
                          </li>
                          <li class="nk-block-tools-opt">
                            <button href="#" class="toggle btn btn-icon btn-primary d-md-none edit-chapter-button"><em class="icon ni ni-edit"></em></button>
                            <button href="#" class="toggle btn btn-primary d-none d-md-inline-flex edit-chapter-button"><em class="icon ni ni-edit"></em><span>Chỉnh sửa bài nghe</span></button>

                          </li>
                      </ul>
                  </div>
          </div><!-- .nk-block-head-content -->
      </div><!-- .nk-block-between -->
  </div><!-- .nk-block-head -->
  <div class="nk-block">
    <div class="card card-bordered h-100">

    
    <div class="card-inner">
      <div class="d-flex mb-3">
        <div class="p-2 ">
          @if($next)
          <a href="{{ $next->slug }}" class="btn btn-icon btn-lg btn-primary"><em class="icon ni ni-arrow-long-right"></em></a>
          @else
          <button class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-right"></em></button>
          @endif
        </div>
        <div class="ms-auto p-2">
          @if($previous)
          <a href="{{ $previous->slug }}"  class="btn btn-icon btn-lg btn-primary"> <em class="icon ni ni-arrow-long-left"></em></a>
          @else
          <button  class="btn btn-icon btn-lg btn-primary" disabled><em class="icon ni ni-arrow-long-left"></em></button>
          @endif

        </div>
      </div>
      
      <div class="feature-box">
      

          {{-- <div class="form-group">
           
          </div> --}}
        
    
      
     </div>
      <div class="title">
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
          <a href="/sach/{{$chapter->books->id  }}/{{ $chapter->books->slug  }}">{{ $chapter->books->name }}</a>
        </div>
        <div class="p-2 flex-fill bg-light">
          <em class="icon ni ni-edit"></em>          
          <a href="/thanh-vien/{{ $chapter->books->users->id }}">{{ $chapter->books->users->profile->displayName }}</a>
        </div>
        <div class="p-2 flex-fill bg-light">
          <em class="icon ni ni-text"></em>
          <span>{{ $chapter->numberOfWords }} chữ</span>
        </div>
        <div class="p-2 flex-fill bg-light">
          <em class="icon ni ni-clock"></em>          
          <span>{{ $chapter->updated_at }}</span>
        </div>
      </div>
      <div class="border px-2"
        
      style="font-size: 16px;line-height:30px;">

      <div style="white-space: break-spaces;"  id="text">
        {{ $content }} 

      </div>

    </div>   
  </div>
  </div><!-- .nk-block -->
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
              <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="regular-price">Tương tác</label>
                      <div class="d-flex">
                        <button class="flex-fill btn btn-icon btn-lg btn-success" id="play-button">
                            <em class="icon ni ni-play m-auto"></em>
                        </button>
                        <button class="flex-fill btn btn-icon btn-lg btn-danger" id="pause-button">
                            <em class="icon ni ni-pause m-auto"></em>
                        </button>
                        <button class="flex-fill btn btn-icon btn-lg btn-warning" id="stop-button">
                            <em class="icon ni ni-stop m-auto"></em>
                        </button>
                      </div>
                  </div>
              </div>
              <div class="col-12">
                  <div class="form-group">
                      <label class="form-label" for="sale-price">
                        <span>Độ cao giọng
                        </span>
                        <em class="icon ni ni-line-chart-up"></em>
                        </label>
                      </label>
                      <div class="form-control-wrap">
                        <input id="pitch" type="range" min="0.1" max="5" step="0.1" value="1" class="form-range">
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
                        <input id="volume" type="range" min="0" max="1" step="0.1" value="1" class="form-range">
                        <output for="volume">1</output>
                    </div>
                </div>
            </div>
              <div class="col-12">
                  <button class="btn btn-primary" id="save-setting"><em class="icon ni ni-plus"></em><span>Lưu cài đặt</span></button>
              </div>
              <div class="col-12">
                <a href="/doc-sach/{{ $chapter->books->slug }}/{{  $chapter->slug }}" class="btn btn-primary w-75" >
                    <em class="icon ni ni-book-read"></em><span>Chuyển sang sách đọc</span>
                </a>
            </div>
          </div>
      </div><!-- .nk-block -->
  </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 697px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 636px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div></div>
</div>




@endsection
@section('additional-scripts')

    <script>
        
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



            if(readCookie('settingListening')){
                var setting = readCookie('settingListening');

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
              var chapter_id =  {!! $chapter->id !!}
              var log = readCookie('readingLog');
              //update cookie
              if(log){             
                  objIndex = log.findIndex((obj => obj.book_id == current_book_id));
                  //book exist
                  if(objIndex > -1){
                      var currentChapterList = log[objIndex].chapter_id;
                      if(currentChapterList.includes(chapter_id)){

                      }
                      else{
                          const updateChapterList = [...currentChapterList,chapter_id]
                          log[objIndex].chapter_id = updateChapterList;

                          createCookie('readingLog',log);
                      }
                      
                  }
                  //book not exist
                  else{
                      var chapter_list = [];
                      chapter_list.push(chapter_id);

                      var reading_object = {
                      'book_id' : current_book_id,
                      'chapter_id' : chapter_list        
                      };       
                      const updateLog = [...log,reading_object]
                      createCookie('readingLog',updateLog);

                  }        
              }
              //create new cookie
              else{
                  var chapter_list = [];
                  chapter_list.push(chapter_id);
                  var reading_object = {
                  'book_id' : current_book_id,
                  'chapter_id' : chapter_list        
                  };            
                  var reading_log = [];
                  reading_log.push(reading_object);
                  createCookie('readingLog',reading_log);

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



        function createCookie(name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = encodeURIComponent(name) + "=" + JSON.stringify(value) + expires + "; path=/";
        }

        function readCookie(name) {
            var result = document.cookie.match(new RegExp(name + '=([^;]+)'));
            result && (result = JSON.parse(result[1]));
            return result;
        }

        function eraseCookie(name) {
            createCookie(name, "", -1);
        }

        $('#save-setting').click(function(){
            eraseCookie('settingListening');
           

            var setting ={
            'voice':window.speechSynthesis.getVoices().find(voice => voice.voiceURI === voiceInEl.value).voiceURI,
            'pitch':pitchInEl.value,
            'speed':rateInEl.value,
            'volume':volumeInEl.value
            }
            createCookie('settingListening',setting);
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
     

       


    </script>
@endsection
