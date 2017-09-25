{!! Html::script("https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js") !!}
{!! Html::script('js/jquery.mask.min.js') !!}
<script>
    $(document).ready(function(){
        $('#phone').mask('9999-9999');
        $('#birth').mask('99/99/9999');
        $('#email').mask("A", {
            translation: {
                "A": { pattern: /[\w@\-.+]/, recursive: true }
            }
        });
    });
</script>