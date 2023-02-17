<div class="section-content">
    <div class="container">
        <h3 class="flex-title">
        <span>Let’s start a project together!</span>
        </h3>
        <div class="grid grid-3 widget-list contact-grid">
        <div class="contact-map">
            <p>
            <b>Office address</b>
            </p>
            <p>6766 Ayala Avenue corner Paseo de Roxas, Makati City</p>
            <p>
            <a href="tel:+63(2)2888954">+63(2)2888954</a> |
            <a href="tel:(02) 676-6167">(02) 676-6167</a>
            </p>
            <img src="/img/ContactUs-SampleMap.png" />
        </div>
        <form class="form grid contact-form" method="post" action="/contact-us-now">
            @csrf
            @if(session()->has('error'))
                {!! session()->get('error') !!}
            @endif
            @if(session()->has('success'))
                {!! session()->get('success') !!}
            @endif
            <p class="full"><b>How can we help?</b></p>
            <label class="form-group">
            <input type="text" placeholder="First Name*" name="first_name" required/>
            </label>
            <label class="form-group">
            <input type="text" placeholder="Last Name*" name="last_name" required/>
            </label>
            <label class="form-group">
            <input type="email" placeholder="Email*"  name="email" required/>
            </label>
            <label class="form-group">
            <input type="text" placeholder="Contact no." name="contact_no"/>
            </label>
            <label class="form-group">
            <input type="text" placeholder="Company" name="company"/>
            </label>
            <label class="form-group">
            <input type="text" placeholder="Job position" name="position"/>
            </label>
            <label class="form-group full">
            <textarea placeholder="Message*" name="message" required></textarea>
            </label>

            <label class="form-group">
            <input type="submit" class="btn pri-btn" value="Submit" />
            </label>
            <label class="form-group">
                <div class="g-recaptcha" data-sitekey="6LfexIgkAAAAANVjhT0uImAXbzYkaOfGffbcT6XH"></div>
            </label>
        </form>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>