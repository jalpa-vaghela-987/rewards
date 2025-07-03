

<style type="text/css">

#searchbar:focus {
    outline: none;
    box-shadow: none;
}

#background_div{
	/* background-image: url({{asset('/other/stock/blue-rounded-long9.png')}});
	 /*background-size: cover;*/
	position: absolute;
    width: 100%;
    z-index: -1;

}

/*
#background_div{
  background: radial-gradient(200px circle at -55px 100px,
                              #2563EB 50%,
                              transparent 51%),
  radial-gradient(200px circle at -65px 220px,
                              #2563EB 50%,
                              transparent 51%),
  radial-gradient(200px circle at -75px 340px,
                              #2563EB 50%,
                              transparent 51%),
  radial-gradient(200px circle at -85px 460px,
                              #2563EB 50%,
                              transparent 51%),
   radial-gradient(200px circle at -92px 560px,
                              #2563EB 50%,
                              transparent 51%),
      radial-gradient(200px circle at -98px 630px,
                              #2563EB 50%,
                              transparent 51%),
         radial-gradient(200px circle at -92px 700px,
                              #2563EB 50%,
                              transparent 51%),
           radial-gradient(200px circle at -85px 770px,
                              #2563EB 50%,
                              transparent 51%),
             radial-gradient(200px circle at -77px 870px,
                              #2563EB 50%,
                              transparent 51%),
                        radial-gradient(200px circle at -85px 970px,
                              #2563EB 50%,
                              transparent 51%),
                        radial-gradient(200px circle at -92px 1070px,
                              #2563EB 50%,
                              transparent 51%),
      radial-gradient(200px circle at -97px 1140px,
                              #2563EB 50%,
                              transparent 51%);


background-color: #F9FAFB;
}

*/



/* this one with the right image and sizing can likely repeat downwards at a high quaility*/
/*#background_div{
	 background-image: url({{asset('/other/stock/blue-rounded-long12.png')}});
    background-color: #F9FAFB;
    background-size: 100% auto;

}*/



/*///// Cards CSS*/
  .card-picture{
    background-size: cover;
  }





  .card-headline{
        font-family: Fira Sans, Trebuchet MS, sans-serif;
  }
  .card-element{
/*    min-width: 125px;
    min-height: 175px;*/
  }
  .card-element-content{
    width: 100%;
    min-height: 75px;
    max-height: 900px;
  }

  .card-element-media{
    object-fit: contain;
  }

  .card-element-editor-content{
    /*height: 100px;*/
    width: 100%;
  }
  .card-element-editor{
    min-height: 70px;
  }
  #quill-editor{
    min-height: 70px;
  }
  #ql-toolbar{
    border-radius: 0.25rem;
  }

  .ql-editor {
    word-break: break-word;
  }

  .selected {
      background-color: rgba(229, 231, 235, 1);
  }
</style>
