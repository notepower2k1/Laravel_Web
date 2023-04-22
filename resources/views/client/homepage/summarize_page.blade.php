@extends('client/homepage.layouts.app')
@section('pageTitle', 'Công cụ tóm tắt')
@section('additional-style')

<style>
#cardShow #inputText , #outputText, #renderInputText{
    font-size: 0.875rem;
    word-break: break-word;
    white-space: pre-wrap;
    line-height: 1.5em;
    overflow: auto;
}


.range-wrap {
  position: relative;
}
.range {
  width: 100%;
}
.bubble {
  background: red;
  color: white;
  padding: 4px 12px;
  position: absolute;
  border-radius: 4px;
  left: 50%;
  transform: translateX(-50%);
}
.bubble::after {
  content: "";
  position: absolute;
  width: 2px;
  height: 2px;
  background: red;
  top: -1px;
  left: 50%;
}

</style>
@endsection
@section('content')
    <div class="p-2">
        <div class="card card-bordered shadow">
           <div class="card-inner">
            <div class="card-header">

                <div class="d-flex justify-content-between">
                    <div class="form-control-wrap w-25">
                        <label for="sumarizeLength" class="form-label">Số câu tóm tắt</label>         
                        <div class="range-wrap">
                            <input type="range" class="range" min="1" max="1" value="1" id ="sumarizeLength">
                            <output class="bubble mt-3" style="display:none"></output>
                        </div>
                    </div>
                    <div class="form-control-wrap w-25">
                        <label for="keywordlength" class="form-label">Số từ khóa</label>         
                        <div class="range-wrap">
                            <input type="range" class="range" min="1" max="1" value="1" id ="keywordlength">
                            <output class="bubble mt-3" style="display:none"></output>
                        </div>
                    </div>
                </div>
            
                
            </div>
            <div class="vh-100" id="cardShow">
                <div class="d-flex flex-row h-100">         
                    <div class="col-6 border p-4">
                        <div class="h-100" id="renderInputText" style="display: none">
                          
                        </div>
                        <textarea id="inputText" class="h-100 w-100 p-2" style="border-color: Transparent;" placeholder="Nhập đoạn văn vào đây!!!" ></textarea>
                    </div>
                    <div class="col-6 border p-4">
                        <div class="h-100" id="outputText"></div>
                    </div>
                </div>
               
            </div>
            <div class="d-flex flex-wrap mt-2 mb-2" id="keywordRender">
                {{-- <span class="badge p-2 bg-outline-primary">Test</span>
                <span class="badge p-2 bg-outline-primary">Test</span>
                <span class="badge p-2 bg-outline-primary">Test</span>
                <span class="badge p-2 bg-outline-primary">Test</span>
                <span class="badge p-2 bg-outline-primary">Test</span>
                <span class="badge p-2 bg-outline-primary">Test</span> --}}
            </div>
            <div class="card border-top p-2">
                <div class="row">
                    <div class="d-flex">                        
                            <div class="col-6 d-flex justify-content-between ps-2 pe-2">
                                <div>
                                    <span id="inputSentenceCount">0 câu</span>
                                    <span class="ms-2" id="inputWordCount">0 từ</span>
                                </div>
                                <button class="btn btn-outline-primary" id="summarize-btn">Tóm tắt</button>
    
                            </div>             
                            <div class="col-6 d-flex justify-content-between ps-2 pe-2">

                                <div>
                                    <span id="outputSentenceCount">0 câu</span>        
                                    <span class="ms-2" id="outputWordCount">0 từ</span>
                                </div>

                                <button class="btn btn-outline-warning" id="clear-btn">Clear</button>
                            </div>
                    
                    
                    </div>
                </div>
            </div>
           </div>
                    
                
              
               
              
            </div>
        </div>
    </div>
    
{{-- <div class="form-control-wrap">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">With textarea</span>
        </div>
        <textarea class="form-control" aria-label="With textarea" id="areaText">Tất cả bánh xu xê đều có hàn the.
            Bánh xu xê đang bị phường Nguyễn Trung Trực (Ba Đình, Hà Nội) cấm bán vì việc sản xuất bắt buộc phải dùng hàn the. Tuy nhiên, các cửa hàng trên phố Hàng Than vẫn làm bánh này khi có khách đặt mua làm lễ ăn hỏi. Trong buổi kiểm tra vệ sinh thực phẩm sáng 1/4, Sở Y tế Hà Nội đã phát hiện hàn the - chất bị cấm dùng trong thức ăm - trong mẻ bánh xu xê 100 cái của cửa hàng Hồng Ninh, 79 Hàng Than. Mảnh giấy quỳ ngả màu đỏ sẫm chứng tỏ hàm lượng hàn the rất cao. Theo bà chủ cửa hàng, vài tháng nay khi phường Nguyễn Trung Trực cấm bán bánh xu xê, bà không bày bán mặt hàng này nữa, trừ khi có khách đặt cho đám cưới đám hỏi. Tuy biết hàn the là chất bị cấm nhưng bà vẫn phải dùng vì chất phụ gia thay thế hàn the không làm được bánh xu xê.
            Ông Nguyễn Trọng Nghĩa, Phó chủ tịch UBND phường, giải thích: Chất phụ gia thay thế hàn the mà ngành y tế cho phép sử dụng tuy rất hiệu quả khi dùng sản xuất giò chả, bánh giò. . nhưng nếu dùng sản xuất bánh xu xê thì không đạt yêu cầu. Bánh xu xê làm từ chất phụ gia này không đủ độ trong, độ dai và không bảo quản được lâu, chỉ để khoảng 2 ngày là chảy nước. Do muốn sản xuất bánh xu xê thì bắt buộc dùng hàn the nên để ngăn ngừa nguy cơ từ chất này đối với sức khỏe, từ vài tháng nay phường Nguyễn Trung Trực đã cấm sản xuất và bán bánh này. Hầu như không cửa hàng nào bày bán nữa nhưng nếu có khách đặt thì vẫn nhận. Theo ông Nghĩa, cấm bán bánh xu xê là một hạ sách, là điều cực chẳng đã vì đây là một mặt hàng truyền thống của phường và rất cần thiết cho lễ ăn hỏi theo phong tục Việt Nam. Tuy nhiên, hiện phường chưa có cách nào để vẫn duy trì mặt hàng này mà không ảnh hưởng đến sức khỏe người dân. Ông Lê Anh Tuấn, Giám đốc Sở Y tế, cho biết sẽ đề nghị các cơ quan nghiên cứu tìm ra một chất phụ gia mới an toàn mà vẫn đảm bảo các yêu cầu về độ ngon miệng, thời hạn bảo quản. . của bánh xu xê.
            </textarea>
    </div>
</div> --}}

@endsection
@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
   
    function wordcount(s) {
        return s.replace(/-/g, ' ').trim().split(/\s+/g).length;
    }

    function charactercount(s){
        return typeof (s) === "string" && s.trim().length;
    }

    function sentencescount(s){
        if(s.match(/[\w|\)][.?!](\s|$)/g)){
            return s.match(/[\w|\)][.?!](\s|$)/g).length
        }
        else{
            Swal.fire({
                icon: 'error',
                title: `Bạn nên nhập ít nhất 1 câu`,
                showConfirmButton: false,
                timer: 2500
            });
        }
    }

    $(document).ready(function() {

    });



    const allRanges = document.querySelectorAll(".range-wrap");
    allRanges.forEach(wrap => {
    const range = wrap.querySelector(".range");
    const bubble = wrap.querySelector(".bubble");

    range.addEventListener("input", () => {
            setBubble(range, bubble);
        });
        setBubble(range, bubble);
    });

    function setBubble(range, bubble) {
        const val = range.value;
        const min = range.min ? range.min : 0;
        const max = range.max ? range.max : 100;
        const newVal = Number(((val - min) * 100) / (max - min));
        bubble.innerHTML = val ;

        // Sorta magic numbers based on size of the native UI thumb
        bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
    }


   

    $('#sumarizeLength').change(function(){
        $(this).next().show();
    })

    $('#keywordlength').change(function(){
        $(this).next().show();
        $('.keywords-span').hide();
        const valueTemp = $(this).val();
        var maxValue = $(this).prop('max');


        for(var i = 0; i < valueTemp;i++){
            $('#keyword-'+i).show();
        }
    })

    $('#inputText').change(function(){
       const text = $(this).val();

        if(text.length > 20){
            $('#sumarizeLength').attr('max', sentencescount(text));
    
           
            const tempValue = Math.round(parseFloat(sentencescount(text))/2);
            $('#sumarizeLength').attr('value', tempValue);


            $.ajax({
                url:'/getKeywords',
                type:"GET",
                data : {
                    "text": text,
                },
                })
                .done(function(res) {
                    $('#keywordRender').empty();
                
                    var keywords = res.keywords;

                 
                    var keyWordsContent = [];
                    

                    Object.keys(keywords).forEach((key, index) => {                 
                        const value = keywords[key];
                        if(value >= 0.2){

                            const temp = `<span id="keyword-${index}" class="keywords-span badge p-2 bg-outline-primary me-2 rounded-pill" style="display:none">${key}</span>`
                            keyWordsContent.push([temp,value])
                        }
                    });

                    keyWordsContent.sort(function(a, b) {
                        return b[1] - a[1];
                    });


                    // console.log(newArray);
                    // console.log(result);

                    //render keyword

                    $('#keywordlength').attr('max', keyWordsContent.length);

                    $('#keywordRender').append(keyWordsContent.map((item)=> item[0]));
                    
                })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
            })
        }
        if (text.length < 20){
            Swal.fire({
                icon: 'error',
                title: `Bạn nên nhập nhiều ký tự hơn`,
                showConfirmButton: false,
                timer: 2500
            });
        }
        if (text.length > 5000){
            Swal.fire({
                icon: 'error',
                title: `Bạn nên nhập ít ký tự hơn`,
                showConfirmButton: false,
                timer: 2500
            });
        }

    })
    $('#summarize-btn').click(function(){
        const input = $('#inputText').val();

        if(input.length > 20){
            $('#inputWordCount').text(wordcount(input) +' từ');
            $('#inputSentenceCount').text(sentencescount(input) +' câu');

            const expectedSentences = $("#sumarizeLength").val();
            const analyzedKeyWords = $("#keywordlength").val();
            $.ajax({
                url:'/summarizeText',
                type:"GET",
                data : {
                    "text": input,
                    "expectedSentences":expectedSentences,
                    'analyzedKeyWords':analyzedKeyWords
                },
                })
                .done(function(res) {
                    $('#inputText').show();
                    $('#renderInputText').hide();
                    $('#outputText').text('');
                    var result = res.result;
                    var content = [];
                    var sentences = input.replace(/\.+/g,'.|').replace(/\?/g,'?|').replace(/\!/g,'!|').split("|");

                    Object.keys(result).forEach((key, index) => {
                        const temp = `<p>${result[key]}</p>`
                        content.push(temp);
                        
                    });

                    var newArray = sentences.map((item, index) => {
                        if (Object.keys(result).map(c => Number(c)).includes(index)) {
                            return `<strong>${item}</strong>`
                        } else {
                            return `<span class="text-muted">${item}</span>`;
                        }
                    });

                 

                    //render output
                    $('#outputText').append(content);



                    //render output information  
                    const output = $('#outputText').text();

                    $('#outputWordCount').text(wordcount(output) +' từ');
                    $('#outputSentenceCount').text(`${Object.keys(result).length}` +' câu')
                        
                        
                    //render input
                    var inputString = newArray.join(' ');
                    $('#inputText').hide();
                    $('#renderInputText').show();
                    $('#renderInputText').text(inputString);

                    var value = document.getElementById('renderInputText').textContent;
                    document.getElementById('renderInputText').innerHTML =
                    marked.parse(value);

                })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                    // If fail
                    console.log(textStatus + ': ' + errorThrown);
            })
    
        }

        else{
            Swal.fire({
                icon: 'error',
                title: `Bạn nên nhập nhiều ký tự hơn`,
                showConfirmButton: false,
                timer: 2500
            });
        }
        
    });

    $('#clear-btn').on('click', function(){
        $('#inputText').show();
        $('#renderInputText').hide();
        $('#keywordRender').empty();
        $('#outputText').text('');
        $('#inputText').val('');

        $('input[type="range"]').attr('value',"1");
        $('input[type="range"]').attr('max',"1");
        $('.bubble').hide();

        $('#outputWordCount').text('0 từ');
        $('#outputSentenceCount').text('0 câu')

        $('#inputWordCount').text('0 từ');
        $('#inputSentenceCount').text('0 câu')
    });

  
</script>


<script>
</script>
@endsection