<?php
require_once 'config.php';
$page_title = 'Virtual Police Station - Tamil Nadu Government';
include 'inc/header.php';
?>

<main>
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Welcome to Virtual Police Station</h1>
                <div class="hero-subtitle">सेवा में आपका स्वागत है | Service at Your Doorstep</div>
                <p>File your complaints online and track their status in real-time. Serving the people of Tamil Nadu with transparency, efficiency, and dedication to justice. Experience modern policing with traditional values.</p>
                <div class="cta-buttons">
                    <a href="complaint.php" class="btn btn-primary btn-pulse">File a Complaint</a>
                    <a href="register.php" class="btn btn-outline">Register Account</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome-section" style="background: linear-gradient(135deg, rgba(139, 0, 0, 0.7), rgba(139, 0, 0, 0.6)), url('public/police-office.png') center/cover; color: white; background-attachment: fixed;">
        <div class="container">
            <h2 class="section-title" style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Digital Policing for Modern Tamil Nadu | आधुनिक तमिलनाडु के लिए डिजिटल पुलिसिंग</h2>
            <p class="section-subtitle" style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                Our Virtual Police Station brings government services directly to your fingertips. 
                No more long queues, no more paperwork hassles. File complaints, track progress, 
                and stay connected with law enforcement - all from the comfort of your home.
            </p>
            
            <div class="service-grid-centered">
                <div class="service-card interactive-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">🏛️</span>
                    <h3>Government Authorized</h3>
                    <p>Official Tamil Nadu Government platform ensuring authenticity and legal compliance for all your complaints and queries.</p>
                </div>
                
                <div class="service-card interactive-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">⚡</span>
                    <h3>Instant Processing</h3>
                    <p>Your complaints are processed immediately upon submission with automated acknowledgment and tracking systems.</p>
                </div>
                
                <div class="service-card interactive-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">🌐</span>
                    <h3>Multi-Language Support</h3>
                    <p>Available in Tamil, Hindi, and English to serve all citizens of Tamil Nadu effectively and inclusively.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section with Images -->
    <section style="padding: 4rem 0; background: white;">
        <div class="container">
            <div class="service-section">
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/8112199/pexels-photo-8112199.jpeg?auto=compress&cs=tinysrgb&w=400&h=300&fit=crop" 
                         alt="Police Office Interior">
                </div>
                
                <div class="service-content">
                    <h2 class="section-title" style="text-align: left;">About Virtual Police Station | वर्चुअल पुलिस स्टेशन के बारे में</h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">
                        Our Virtual Police Station represents a revolutionary approach to law enforcement services, 
                        bringing transparency, efficiency, and accessibility to complaint management. We leverage 
                        modern technology to serve citizens better while maintaining the highest standards of 
                        security and confidentiality.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                        <div>
                            <h4 style="color: var(--primary-maroon); margin-bottom: 0.5rem;">✓ Digital First | डिजिटल प्राथमिकता</h4>
                            <p style="font-size: 0.9rem;">Modern online platform with mobile-friendly design</p>
                        </div>
                        <div>
                            <h4 style="color: var(--primary-maroon); margin-bottom: 0.5rem;">✓ Transparent | पारदर्शी</h4>
                            <p style="font-size: 0.9rem;">Complete transparency in complaint handling process</p>
                        </div>
                        <div>
                            <h4 style="color: var(--primary-maroon); margin-bottom: 0.5rem;">✓ Secure | सुरक्षित</h4>
                            <p style="font-size: 0.9rem;">Advanced encryption and data protection protocols</p>
                        </div>
                        <div>
                            <h4 style="color: var(--primary-maroon); margin-bottom: 0.5rem;">✓ Accessible | सुलभ</h4>
                            <p style="font-size: 0.9rem;">Available 24/7 from any device, anywhere</p>
                        </div>
                    </div>
                    <a href="register.php" class="btn btn-primary btn-pulse">Get Started Today | आज ही शुरू करें</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section with Images -->
    <section class="features-section" style="background: linear-gradient(rgba(139, 0, 0, 0.7), rgba(139, 0, 0, 0.6)), url('public/police-station-features.png') center/cover; color: white; background-attachment: fixed;">
        <div class="container">
            <h2 class="section-title" style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Why Choose Our Virtual Police Station? | हमारे वर्चुअल पुलिस स्टेशन को क्यों चुनें?</h2>
            <p class="section-subtitle" style="color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Experience cutting-edge technology combined with traditional police values for comprehensive citizen services</p>
            
            <div class="features-grid">
                <div class="feature-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">🚔</span>
                    <h3>Easy Online Filing | आसान ऑनलाइन फाइलिंग</h3>
                    <p>Submit complaints from anywhere, anytime. No need to visit the police station physically. Simple forms, quick submission process.</p>
                </div>
                
                <div class="feature-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">📊</span>
                    <h3>Live Status Updates | लाइव स्टेटस अपडेट</h3>
                    <p>Monitor your complaint progress in real-time. Receive instant notifications about status changes and investigation updates.</p>
                </div>
                
                <div class="feature-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">🔐</span>
                    <h3>Secure & Confidential | सुरक्षित और गोपनीय</h3>
                    <p>Bank-level security ensures your personal information and complaint details remain completely confidential and protected.</p>
                </div>
                
                <div class="feature-card" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <span class="feature-icon">📱</span>
                    <h3>24/7 Availability | 24/7 उपलब्धता</h3>
                    <p>Our digital police station never closes. File complaints, check status, and access services round the clock from any device.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section with Images -->
    <section class="how-it-works" style="background: linear-gradient(rgba(139, 0, 0, 0.7), rgba(139, 0, 0, 0.6)), url('public/how-it-works-bg.png') center/cover; color: white; background-attachment: fixed;">
        <div class="container">
            <div class="service-section">
                
                <div class="service-content">
                    <h2 class="section-title" style="text-align: left; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">How It Works | यह कैसे काम करता है</h2>
                    <p class="section-subtitle" style="text-align: left; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Simple, fast, and efficient complaint filing process in just three easy steps. Get started in minutes!</p>
                    
                    <div class="steps-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin: 3rem 0; justify-items: center;">
                        <div class="step-card interactive-step" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); backdrop-filter: blur(15px); border: 2px solid rgba(139, 0, 0, 0.2); box-shadow: 0 15px 35px rgba(0,0,0,0.15); transition: all 0.4s ease; cursor: pointer; max-width: 300px; width: 100%;">
                            <div class="step-number" style="background: linear-gradient(135deg, var(--secondary-gold), #FFA500); color: var(--text-dark); box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);">1</div>
                            <h3 style="color: var(--primary-maroon); font-size: 1.3rem; margin-bottom: 1rem;">File Your Complaint | शिकायत दर्ज करें</h3>
                            <p style="color: #444; font-size: 0.95rem; line-height: 1.6;">Fill out our simple online form with your complaint details. Choose from various categories like theft, fraud, harassment, and more.</p>
                        </div>
                        
                        <div class="step-card interactive-step" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); backdrop-filter: blur(15px); border: 2px solid rgba(139, 0, 0, 0.2); box-shadow: 0 15px 35px rgba(0,0,0,0.15); transition: all 0.4s ease; cursor: pointer; max-width: 300px; width: 100%;">
                            <div class="step-number" style="background: linear-gradient(135deg, var(--secondary-gold), #FFA500); color: var(--text-dark); box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);">2</div>
                            <h3 style="color: var(--primary-maroon); font-size: 1.3rem; margin-bottom: 1rem;">Get Unique ID | विशिष्ट आईडी प्राप्त करें</h3>
                            <p style="color: #444; font-size: 0.95rem; line-height: 1.6;">Receive an instant complaint ID (e.g., #VPS000001) for tracking. This ID helps you monitor progress and communicate with officers.</p>
                        </div>
                        
                        <div class="step-card interactive-step" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); backdrop-filter: blur(15px); border: 2px solid rgba(139, 0, 0, 0.2); box-shadow: 0 15px 35px rgba(0,0,0,0.15); transition: all 0.4s ease; cursor: pointer; max-width: 300px; width: 100%;">
                            <div class="step-number" style="background: linear-gradient(135deg, var(--secondary-gold), #FFA500); color: var(--text-dark); box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);">3</div>
                            <h3 style="color: var(--primary-maroon); font-size: 1.3rem; margin-bottom: 1rem;">Track & Resolve | ट्रैक और समाधान</h3>
                            <p style="color: #444; font-size: 0.95rem; line-height: 1.6;">Monitor real-time status updates: Pending → In Progress → Resolved. Receive SMS/email notifications at each stage.</p>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 3rem;">
                        <a href="complaint.php" class="btn btn-primary btn-pulse">Start Filing Your Complaint Now | अभी शिकायत दर्ज करना शुरू करें</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergency Contact Section -->
    <section style="padding: 5rem 0; background: linear-gradient(135deg, var(--primary-maroon), #A52A2A); color: white;">
        <div class="container">
            <h2 style="color: white; text-align: center; margin-bottom: 3rem; font-size: 2.5rem;">Emergency & Support Services | आपातकालीन और सहायता सेवाएं</h2>
            <div class="service-section">
                <div class="service-content">
                    <div class="dashboard-grid">
                        <div class="service-card" style="background: rgba(255,255,255,0.95); color: var(--text-dark);">
                            <span class="feature-icon" style="color: var(--error-red);">🚨</span>
                            <h3 style="color: var(--error-red);">Emergency Services</h3>
                            <div class="stat-number" style="color: var(--error-red); font-size: 3rem;">100</div>
                            <p>For immediate life-threatening emergencies, call 100. Police, Fire, and Medical emergency response available 24/7.</p>
                        </div>
                        
                        <div class="service-card" style="background: rgba(255,255,255,0.95); color: var(--text-dark);">
                            <span class="feature-icon" style="color: var(--primary-maroon);">📞</span>
                            <h3 style="color: var(--primary-maroon);">Helpline Support</h3>
                            <div class="stat-number" style="color: var(--primary-maroon); font-size: 3rem;">1077</div>
                            <p>For general inquiries, complaint status, and non-urgent matters. Trained support staff available to assist you.</p>
                        </div>
                        
                        <div class="service-card" style="background: rgba(255,255,255,0.95); color: var(--text-dark);">
                            <span class="feature-icon" style="color: var(--success-green);">💬</span>
                            <h3 style="color: var(--success-green);">Digital Platform</h3>
                            <div class="stat-number" style="color: var(--success-green); font-size: 3rem;">24/7</div>
                            <p>Complete online services including complaint filing, status tracking, and document submission available round the clock.</p>
                        </div>
                    </div>
                </div>
                <div class="service-image">
                    <img src="https://images.pexels.com/photos/8112324/pexels-photo-8112324.jpeg?auto=compress&cs=tinysrgb&w=400&h=300&fit=crop" 
                         alt="Police Office Emergency Services">
                </div>
            </div>
        </div>
    </section>
</main>

<style>
@media (max-width: 768px) {
    .about-grid {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    section[style*="grid-template-columns: 1fr 1fr"] > div > div > div:last-child {
        order: -1;
    }
    
    .service-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php include 'inc/footer.php'; ?>
                    </div>
                    
                    <div class="dashboard-card">