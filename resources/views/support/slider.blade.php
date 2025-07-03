 


 <div class="shadow bg-white rounded-xl border border-gray-200 border-solid my-2">
        <div class="p-2  py-1 text-xl font-semibold  text-left flex cursor-pointer  question_link
         text-blue-900 border-b border-gray-200">
            <svg class="ml-4 mr-5  mt-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <div class="font-handwriting mx-2 md:mx-6 lg:mx-20 xl:mx-26 p-2 md:px-6">{{$question}}</div>
        </div>


        <div class="text-md px-4 py-6 question_answer hidden
         text-gray-900 text-left leading-6">
            {!! $answer !!}
        </div>
    </div>