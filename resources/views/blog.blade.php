@extends('main')
@section('stylesheet')
    <script type="text/javascript" src="https://unpkg.com/vue@latest/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection
@section('icerik')
<div id="vue">
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
            @if (explode(":",explode(",",$user->social)[1])[1])
                <div class="github">
                    <div class="github-flair" style="box-sizing: border-box; line-height: normal; display: flex; align-items: center; width: 290px; color: rgb(85, 85, 85); position: relative; border: 2px solid rgb(209, 213, 218); border-radius: 3px; padding: 5px 10px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;">
                        <a target="_blank" id="github_link"><i class="fa fa-github" style="fill: rgb(209, 213, 218);color: rgb(255, 255, 255);position: absolute;top: 0px;right: 0px;border: 0px;"></i></a>
                        <div style="text-align: center; position: relative; width: 75px; height: 75px; margin-left: 5px;">
                            <div class="flair-rainbow-avatar"></div><img id="github_resim" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                        <div class="info" style="width: 160px; text-align: right; font-size: 14px;">
                            <div class="user-profile-bio">&nbsp;<span id="github_bio" style="color: white;" >Bio</span></div>
                            <div class="meta">
                                <span title="Takipçiler"><i class="fa fa-user"></i> <span id="github_followers" style="color: white;" >Follower</span>&nbsp;</span>
                                <span title="Takip Edilen"><i class="fa fa-users"></i> <span id="github_following" style="color: white;" >Following</span>&nbsp;</span>
                                <span title="Toplam Repositoriler"><i class="fa fa-align-justify"></i> <span id="public_repos" style="color: white;" >Repos</span></span>
                            </div>
                            <div class="location"><i class="fa fa-map"></i> <span>&nbsp;<span id="github_location" style="color: white;" >Location</span></span></div>
                            <div class="blog"><a id="github_blog" target="_blank" style="color: #ffffff85;">Blog</a></div>
                        </div>
                    </div>
                </div>
                <br>
            @endif
            @if (explode(":",explode(",",$user->social)[3])[1])
                <div class="stackoverflow">
                    <div class="stackoverflow-flair" style="box-sizing: border-box; line-height: normal; display: flex; align-items: center; width: 290px; color: rgb(85, 85, 85); position: relative; border: 2px solid rgb(209, 213, 218); border-radius: 3px; padding: 5px 10px; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;">
                        <a target="_blank" id="stackoverflow_link"><i class="fa fa-stack-overflow" style="fill: rgb(209, 213, 218);color: rgb(255, 255, 255);position: absolute;top: 0px;right: 0px;border: 0px;"></i></a>
                        <div style="text-align: center; position: relative; width: 75px; height: 75px; margin-left: 5px;">
                            <div class="flair-rainbow-avatar"></div><img id="stackoverflow_resim" style="width: 100%; height: 100%; border-radius: 50%;">
                        </div>
                        <div class="info" style="width: 160px; text-align: right; font-size: 14px;">
                            <div class="user-profile-bio">&nbsp;<span id="stackoverflow_bio" style="color: white;" >Bio</span></div>
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
                <br>
            @endif
        </div>
        <div id="sag">
            <main class="posts" style="padding: 0 !important;max-width: 100% !important; width: 95% !important; margin: auto !important;">
                @if ($kategori_one) <h1 style="text-align: center; background-image: url(/img/{{$kategori_one->resim}});background-repeat: no-repeat;background-size: contain;">{{$kategori_one->baslik}}</h1> @endif
                <div class="posts-group">
                    <ul class="posts-list">
                        <li class="post-item" v-for="m in mesaj">
                            <a :href="'/blog/'+ m.url">
                                <span class="post-title">
                                    @{{m.baslik}}
                                    <i class="fa fa-check" title="Yazı Öne Çıkarıldı" v-if="m.onecikarilan == 1"></i>
                                </span>
                                <span class="post-day">
                                    @{{ m.created_at.split(" ").shift() }} /
                                    <b>@{{ m.kategori.baslik }}</b> /
                                    @{{ (m.yorum).length }} Yorum
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="btn btn-default" v-show="prev" style="display: inline;" @click="prevPage()">Önceki</button>
                <span>Sayfa @{{ current }} / @{{ toplam }}</span>
                <button class="btn btn-default" v-show="next" style="display: inline;" @click="nextPage()">Sonraki</button>
            </main>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script>
        let v = new Vue({
            el: '#vue',
            data: {
                current: 1,
                next: true,
                prev: false,
                toplam:0,
                mesaj: [],
                kategori:@if($kategori_one) '{{$kategori_one->url}}' @else null @endif
            },
            methods: {
                nextPage: function (){
                    axios.post('{{url('/')}}/api/blog',{ page: this.current+1, kategori:this.kategori})
                            .then(response => (
                                this.mesaj = response.data.yazilar,
                                this.toplam = response.data.toplam,
                                v.kosul()
                            )).catch(error => {});
                    this.current = this.current + 1;
                },
                prevPage: function (){
                    axios.post('{{url('/')}}/api/blog',{ page: this.current-1, kategori:this.kategori})
                            .then(response => (
                                this.mesaj = response.data.yazilar,
                                this.toplam = response.data.toplam,
                                v.kosul()
                            )).catch(error => {});
                    this.current = this.current - 1;
                },
                kosul: function() {
                    if (this.current >= this.toplam) {
                        this.next = false;
                    }else{
                        this.next = true;
                    }
                    if((this.current < 2)){
                        this.prev = false;
                    }else{
                        this.prev = true;
                    }
                    /*
                    console.log("current:"+this.current);
                    console.log("toplam:"+this.toplam);
                    console.log("kategori:"+this.kategori);
                    */
                },
            },
            async created (){
                axios.post('{{url('/')}}/api/blog',{ page: 1, kategori:this.kategori})
                        .then(response => (
                            this.mesaj = response.data.yazilar,
                            this.toplam = response.data.toplam,
                            v.kosul()
                        ))
                        .catch(error => {});
            }
        });
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