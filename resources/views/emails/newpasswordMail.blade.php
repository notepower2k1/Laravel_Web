


<div class="card card-bordered">
    <div class="card-inner">
        <table class="email-wraper">
            <tbody><tr>
                <td class="py-5">
                    <table class="email-header">
                        <tbody>
                            <tr>
                                <td class="text-center pb-4">
                                    <a href="#"><img class="email-logo" src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/logo.png" alt="logo"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="email-body text-center">
                        <tbody>
                            <tr>
                                <td class="px-3 px-sm-5 pt-3 pt-sm-5 pb-3">
                                    <h2 class="email-heading">Mật khẩu mới</h2>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 px-sm-5 pb-2">
                                    <p>{{ $mailData['title'] }}</p>
                                    <p>Mật khẩu mới của bạn là: </p>
                                    <button class="email-btn">{{ $mailData['body'] }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 px-sm-5 pt-4 pb-3 pb-sm-5">
                                    <p>{{ $mailData['content'] }}</p>
                                    <p class="email-note">Đây là email được tạo tự động vui lòng không trả lời email này. Nếu bạn gặp phải bất kỳ vấn đề nào, vui lòng liên hệ với chúng tôi thông qua nguyenthach617@gmail.com</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   
                </td>
            </tr>
        </tbody></table>
    </div>
</div>
