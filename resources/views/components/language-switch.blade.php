<div class="d-flex align-items-center gap-3">
    
    <span class="lang-label {{ app()->getLocale() == 'id' ? 'label-active' : 'label-inactive' }}">
        ID
    </span>

    <label class="neu-switch">
        <input type="checkbox" id="language-toggle" {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
        <span class="slider"></span>
    </label>

    <span class="lang-label {{ app()->getLocale() == 'en' ? 'label-active' : 'label-inactive' }}">
        EN
    </span>

</div>

<style>
    .lang-label {
        font-weight: 800;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .label-active {
        color: #ffffffff; 
        opacity: 1;
        transform: scale(1.1);
    }

    .label-inactive {
        color: #198754;
        opacity: 0.5;
    }

    .neu-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
        margin-bottom: 0;
    }

    .neu-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #f0f0f3; 
        transition: .4s;
        border-radius: 34px;
        box-shadow: inset 3px 3px 5px #cbced1, 
                    inset -3px -3px 5px #ffffffff;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: #f0f0f3;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 2px 2px 4px #cbced1, 
                    -2px -2px 4px #ffffffff;
    }

    input:checked + .slider:before {
        transform: translateX(22px);
        background-color: #198754;
        box-shadow: inset 2px 2px 4px #0f5132, 
                    inset -2px -2px 4px #25c97b;
    }
</style>

<script>
    document.getElementById('language-toggle').addEventListener('change', function() {
        let targetLang = this.checked ? 'en' : 'id';
        
        let url = "{{ route('lang.switch', ':lang') }}";
        url = url.replace(':lang', targetLang);

        window.location.href = url;
    });

    document.querySelectorAll('.lang-label').forEach(label => {
        label.addEventListener('click', function() {
            let text = this.innerText.trim();
            let lang = (text === 'ID') ? 'id' : 'en';
            
            let currentLang = "{{ app()->getLocale() }}";
            if(lang !== currentLang) {
                let url = "{{ route('lang.switch', ':lang') }}";
                url = url.replace(':lang', lang);
                window.location.href = url;
            }
        });
    });
</script>