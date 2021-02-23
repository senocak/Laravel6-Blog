@extends('main')
@section('stylesheet')
    {!! Html::script('js/prism.js') !!}
    <script type="text/javascript" src="https://unpkg.com/vue@latest/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection
@section('icerik')
    <div id="wrapper">
        <div id="sol">
            <ul class="tree">
                @foreach ($kategoriler as $kategori)
                    @if (count($kategori->children))
                        <li><a href="/blog/kategori/{{ $kategori->url }}">{{ $kategori->baslik }} ({{count($kategori->yazilar)}})</a>
                            <ul>
                                @foreach ($kategori->children as $kategori2)
                                    <li><a href="/blog/kategori/{{ $kategori2->url }}">{{$kategori2->baslik}} ({{count($kategori2->yazilar)}})</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a href="/blog/kategori/{{ $kategori->url }}">{{ $kategori->baslik }} ({{count($kategori->yazilar)}})</a></li>
                    @endif
                @endforeach
            </ul>
            <br>
            <div class="github">
                <div class="github-flair" style="box-sizing: border-box; line-height: normal; display: flex; align-items: center; width: 290px; color: rgb(85, 85, 85); position: relative; border: 2px solid rgb(209, 213, 218); border-radius: 3px; padding: 5px 10px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;">
                    <a target="_blank" id="github_link"><i class="fa fa-github" style="fill: rgb(209, 213, 218);color: rgb(255, 255, 255);position: absolute;top: 0px;right: 0px;border: 0px;"></i></a>
                    <div style="text-align: center; position: relative; width: 75px; height: 75px; margin-left: 5px;">
                        <div class="flair-rainbow-avatar"></div><a target="_blank" id="github_link"><img id="github_resim" style="width: 100%; height: 100%; border-radius: 50%;"></a>
                    </div>
                    <div class="info" style="width: 160px; text-align: right; font-size: 14px;">
                        <div class="user-profile-bio">&nbsp;<span style="color: white;" id="github_bio">Bio</span></div>
                        <div class="meta">
                            <span title="Takipçiler"><i class="fa fa-user"></i> <span id="github_followers" style="color: white;" >Follower</span>&nbsp;</span>
                            <span title="Takip Edilen"><i class="fa fa-users"></i> <span id="github_following" style="color: white;" >Following</span>&nbsp;</span>
                            <span title="Toplam Repositoriler"><i class="fa fa-align-justify"></i> <span id="public_repos" style="color: white;" >Repos</span></span>
                        </div>
                        <div class="location"><i class="fa fa-map"></i> <span>&nbsp;<span style="color: white;" id="github_location">Location</span></span></div>
                        <div class="blog"><a id="github_blog" target="_blank" style="color: #ffffff85;" >Blog</a></div>
                    </div>
                </div>
            </div>
            <br>
            <div class="stackoverflow">
                <div class="stackoverflow-flair" style="box-sizing: border-box; line-height: normal; display: flex; align-items: center; width: 290px; color: rgb(85, 85, 85); position: relative; border: 2px solid rgb(209, 213, 218); border-radius: 3px; padding: 5px 10px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;">
                    <a target="_blank" id="stackoverflow_link"><i class="fa fa-stack-overflow" style="fill: rgb(209, 213, 218);color: rgb(255, 255, 255);position: absolute;top: 0px;right: 0px;border: 0px;"></i></a>
                    <div style="text-align: center; position: relative; width: 75px; height: 75px; margin-left: 5px;">
                        <div class="flair-rainbow-avatar"></div><a target="_blank" id="stackoverflow_link"><img id="stackoverflow_resim" style="width: 100%; height: 100%; border-radius: 50%;"></a>
                    </div>
                    <div class="info" style="width: 160px; text-align: right; font-size: 14px;">
                        <div class="user-profile-bio">&nbsp;<span style="color: white;" id="stackoverflow_bio">Bio</span></div>
                        <div class="meta">
                            <span title="Altın"><i class="fa fa-circle" style="color:gold;"></i> <span id="stackoverflow_gold" style="color: white;" >Gold</span>&nbsp;</span>
                            <span title="Bronz"><i class="fa fa-circle" style="color:#cd7f32"></i> <span id="stackoverflow_bronze" style="color: white;" >Bronze</span>&nbsp;</span>
                            <span title="Gümüş"><i class="fa fa-circle" style="color:gray"></i> <span id="stackoverflow_silver" style="color: white;" >Silver</span></span>
                        </div>
                        <div class="location"><i class="fa fa-map"></i> <span id="stackoverflow_location" style="color: white;" >Location</span></div>
                        <div class="blog"><a id="stackoverflow_blog" target="_blank" style="color: #ffffff85;">Blog</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sag">
            <main class="posts" style="padding-left: 0px;margin-left: initial;max-width: 95%; width: 95%;">
                <img src="/img/{{ $yazi->kategori->resim }}">
                <div style="width: 100%; display: grid;">
                    <h3 class="post-title">{{$yazi->baslik}}</h3>
                    <div style="display: table-cell;">
                        {{ date('d/m/Y h:ia', strtotime($yazi->created_at)) }} /
                        <a href="/blog/kategori/{{ $yazi->kategori->url }}">{{ $yazi->kategori->baslik }}</a>
                    </div>
                </div>
                <div class="post-content" style="text-align: justify;">
                    {!! $yazi->icerik !!}
                    @if ($yazi->github_repo != null)
                        <div class="github-widget-repo" data-repo="{{$yazi->github_repo}}"></div>
                    @endif
                </div>
                @if (count(explode(',', $yazi->etiketler)) > 1)
                    <div class="post-info">
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag meta-icon">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7" y2="7"></line>
                            </svg>
                            @foreach (explode(',', $yazi->etiketler) as $etiket)
                                <span class="tag" title="{{$etiket}}">{{$etiket}}</span>
                            @endforeach
                        </p>
                    </div>
                @endif
                <hr>
                <div id="app">
                    {!! Form::email('email',null, array("placeholder"=>"Email", "required"=>"required","autocomplete"=>"off", "v-model"=>"email")) !!}
                    {!! Form::textarea('body',null,['style'=>'height:100px',"placeholder"=>"Yorumunuz", "required"=>"required", "v-model"=>"body"]) !!}
                    {{ Form::button('Gönder', ['@click' => 'send',"style"=>"width: 100%; color:white;"] )  }}
                    <p v-if="seen || status == 201" style="background-color: black;padding: 7px;text-align: center;">@{{ mesaj }}</p>
                </div>
                <script>
                    window.onload=function(){
                        Vue.component('modal', {
                            template: '#modal-template'
                        })
                        new Vue({
                            el: '#app',
                            data: {
                                email: "",
                                body: "",
                                seen: false,
                                mesaj:"",
                                status: 0
                            },
                            methods:{
                                validEmail: function (email) {
                                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                    return re.test(email);
                                },
                                send: function (){
                                    if(!this.validEmail(this.email)){
                                        this.seen = true;
                                        this.mesaj = "Geçersiz Email"
                                    }else if (this.email == "" || this.body == ""){
                                        this.seen = true;
                                        this.mesaj = "Tüm Alanları Doldurunuz."
                                    }else{
                                        axios.post('{{url('/')}}/blog/{{$yazi->url}}',{ email: this.email, body: this.body})
                                        .then(response => (
                                            this.status = response.status,
                                            this.mesaj = response.data.mesaj
                                        ))
                                        .catch(error => {});
                                    }
                                    this.email = "";
                                    this.body = "";
                                }
                            }
                        })
                    }
                </script>
                <br>
                <div id="reader">
                    @forelse($yazi->yorum as $yorum)
                        <div class="comment_box" >
                            <img src="/img/avatar.png">
                            <div class="inside_comment">
                                <div class="comment-meta">
                                    <div class="commentsuser">{{$yorum->email}}</div>
                                    <div class="comment_date">{{date('d/m/Y h:ia', strtotime($yorum->created_at))}}</div>
                                </div>
                            </div>
                            <div class="comment-body">
                                <p style="text-align: justify">{{$yorum->body}}</p>
                            </div>
                        </div>
                    @empty
                        İlk Yorum Yazan Siz Olun...
                    @endforelse
                </div>
            </main>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(function () {
            $('.github-widget-repo').each(function () {
                var $container = $(this);
                var repo_name = $container.data('repo');
                var html_encode = function (str) {
                    if (!str || str.length == 0) return "";
                    return str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                };
                $.ajax({
                    url: 'https://api.github.com/repos/' + repo_name,
                    dataType: 'jsonp',
                    success: function (results) {
                        var repo = results.data;
                        var pushed_at = repo.pushed_at.substr(0, 10);
                        var url_regex = /((http|https):\/\/)*[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/
                        if (repo.homepage && (m = repo.homepage.match(url_regex))) {
                            if (m[0] && !m[1]) repo.homepage = 'http://' + m[0];
                        }else {
                            repo.homepage = '';
                        }
                        var $widget = $(' \
                            <div class="github-box repo">  \
                                <div class="github-box-title"> \
                                    <h3> \
                                        <a class="owner" href="' + repo.owner.url.replace('api.', '').replace('users/', '') + '" target="_blank">' + repo.owner.login + '</a> \
                                        /  \
                                        <a class="repo" href="' + repo.url.replace('api.', '').replace('repos/', '') + '" target="_blank">' + repo.name + '</a> \
                                    </h3> \
                                    <div class="github-stats"> \
                                        Watch<a class="watchers" title="İzleyenler" href="' + repo.url.replace('api.', '').replace('repos/', '') + '/watchers" target="_blank">' + repo.subscribers_count + '</a> \
                                        Star<a class="watchers" title="Takip Edenler" href="' + repo.url.replace('api.', '').replace('repos/', '') + '/stargazers" target="_blank">' + repo.watchers + '</a> \
                                        Fork<a class="forks" title="Klonlama" href="' + repo.url.replace('api.', '').replace('repos/', '') + '/network" target="_blank">' + repo.forks + '</a> \
                                    </div> \
                                </div> \
                                <div class="github-box-content"> \
                                    <p class="description">' + html_encode(repo.description) + '</p> \
                                    <p class="link"><a href="' + repo.homepage + '">' + html_encode(repo.homepage) + '</a></p> \
                                    <a style="float: right;color: black;font-weight: bold;padding: 0 10px;border: 1px solid #DDD;background: -webkit-linear-gradient(#F5F5F5,#E5E5E5);" href="' + repo.url.replace('api.', '').replace('repos/', '') + '/zipball/master">İndir</a> \
                                </div> \
                            </div>');
                        $widget.appendTo($container);
                    }
                })
            });
        });
    </script>
    <script>
        stackoverflow();
        github();
        function github() {
            $.ajax({
                url: 'https://api.github.com/users/{{ explode(":",explode(",",$user->social)[1])[1] }}',
                dataType: 'jsonp',
                success: function (results) {
                    var repo = results.data;
                    var html_url = repo.html_url;
                    var resim = repo.avatar_url;
                    var bio = repo.bio;
                    var followers = repo.followers;
                    var following = repo.following;
                    var public_repos = repo.public_repos;
                    var location = repo.location;
                    var blog = repo.blog;
                    //console.log(repo);
                    document.getElementById("github_link").href = html_url;
                    document.getElementById("github_resim").src = resim;
                    document.getElementById("github_bio").innerHTML = bio;
                    document.getElementById("github_followers").innerHTML = followers;
                    document.getElementById("github_following").innerHTML = following;
                    document.getElementById("public_repos").innerHTML = public_repos;
                    document.getElementById("github_location").innerHTML = location;
                    document.getElementById("github_blog").href = blog;
                    document.getElementById("github_blog").innerHTML = blog;
                }
            })
        }
        function stackoverflow() {
            $.ajax({
                url: 'https://api.stackexchange.com/2.2/users/{{ explode(":",explode(",",$user->social)[3])[1] }}?order=desc&sort=reputation&site=stackoverflow',
                dataType: 'jsonp',
                success: function (results) {
                    var user = results.items[0];
                    var display_name = user.display_name;
                    var link = user.link;
                    var location = user.location;
                    var profile_image = user.profile_image;
                    var reputation = user.reputation;
                    var website_url = user.website_url;
                    var gold = user.badge_counts.gold;
                    var bronze = user.badge_counts.bronze;
                    var silver = user.badge_counts.silver;
                    console.log(user);
                    document.getElementById("stackoverflow_link").href = link;
                    document.getElementById("stackoverflow_resim").src = profile_image;
                    document.getElementById("stackoverflow_bio").innerHTML = display_name;
                    document.getElementById("stackoverflow_blog").href = website_url;
                    document.getElementById("stackoverflow_blog").innerHTML = website_url;
                    document.getElementById("stackoverflow_location").innerHTML = location;
                    document.getElementById("stackoverflow_gold").innerHTML = gold;
                    document.getElementById("stackoverflow_bronze").innerHTML = bronze;
                    document.getElementById("stackoverflow_silver").innerHTML = silver;
                }
            })
        }
    </script>
@endsection