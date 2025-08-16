@extends('layouts.app')

@section('title', 'HR Policies - OptiStaff')

@section('content')
<div class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar Navigation -->
    

    <!-- Main Content -->
    <main class="flex-1 px-6 md:px-12 py-10">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-10 px-6 rounded-lg shadow-md mb-10 text-center">
            <h1 class="text-3xl font-bold mb-3">OptiStaff HR Policy Handbook</h1>
            <p class="text-gray-200 text-lg max-w-3xl mx-auto">
                This handbook outlines the official HR policies of OptiStaff, covering the full employment life cycle to ensure fairness, transparency, and compliance.
            </p>
        </div>

        <!-- Beginning Employment -->
        <section id="beginning" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">1. Beginning Employment</h2>
            <p class="text-gray-600 leading-relaxed">
                OptiStaff is committed to fair, transparent, and inclusive recruitment practices.
            </p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li><strong>Recruitment & Selection:</strong> Candidates are selected based on merit, competencies, and alignment with company values.</li>
                <li><strong>Induction & Onboarding:</strong> New employees undergo structured induction programs to integrate into the organisation effectively.</li>
                <li><strong>Referral Policy:</strong> Employees who refer successful candidates may be eligible for referral bonuses, as per company guidelines.</li>
            </ul>
        </section>

        <!-- Reward -->
        <section id="reward" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">2. Reward & Compensation</h2>
            <p class="text-gray-600 leading-relaxed">
                OptiStaff provides competitive and transparent reward systems to recognize employee contributions.
            </p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Clear job grading and pay structures.</li>
                <li>Annual performance reviews with merit-based increases.</li>
                <li>Comprehensive benefits including pensions, allowances, and voluntary contributions.</li>
            </ul>
        </section>

        <!-- Health, Safety & Wellbeing -->
        <section id="wellbeing" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">3. Health, Safety & Wellbeing</h2>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Safe working conditions and compliance with occupational health laws.</li>
                <li>Support for mental health and stress management.</li>
                <li>Guidelines for handling hazardous materials and maintaining workplace hygiene.</li>
            </ul>
        </section>

        <!-- Employee Relations -->
        <section id="relations" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">4. Employee Relations & General HR Issues</h2>
            <p class="text-gray-600">OptiStaff promotes positive employee relations, voice, and involvement.</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Disciplinary and grievance procedures in line with due process.</li>
                <li>Policies on holidays, parental leave, and special leave (e.g., caregiving, union activities).</li>
                <li>Clear anti-harassment and anti-bullying guidelines.</li>
            </ul>
        </section>

        <!-- Learning & Development -->
        <section id="learning" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">5. Learning & Development</h2>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Access to training courses and development programs.</li>
                <li>Secondment opportunities for career growth.</li>
                <li>Support for professional certification and fees where applicable.</li>
            </ul>
        </section>

        <!-- Equality -->
        <section id="equality" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">6. Equality, Diversity & Inclusion</h2>
            <p class="text-gray-600">
                OptiStaff is committed to maintaining an inclusive workplace that celebrates diversity and prohibits discrimination of any kind.
            </p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Equal treatment in recruitment, promotion, and reward.</li>
                <li>Policies aligned with global and local anti-discrimination laws.</li>
                <li>Embedding inclusivity in company values, training, and communications.</li>
            </ul>
        </section>

        <!-- Other Policies -->
        <section id="other" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">7. Other Organisational Policies</h2>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li><strong>Corporate Responsibility:</strong> Commitment to sustainability and ethical business practices.</li>
                <li><strong>Anti-Bribery & Corruption:</strong> Zero tolerance for bribery, fraud, or unethical practices.</li>
                <li><strong>Technology Use:</strong> Responsible use of IT systems, including social media and data privacy compliance.</li>
            </ul>
        </section>

        <!-- Ending Employment -->
        <section id="ending" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">8. Ending Employment</h2>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mt-3">
                <li>Notice periods clearly outlined in employment contracts.</li>
                <li>Redundancy procedures, including consultation and support.</li>
                <li>Clear guidelines on retirement, resignation, and termination processes.</li>
            </ul>
        </section>

        <!-- Beyond -->
        <section id="beyond" class="mb-12">
            <h2 class="text-2xl font-semibold text-blue-700 mb-3">9. Beyond the Organisation</h2>
            <p class="text-gray-600 leading-relaxed">
                HR policies may extend to external collaborations, including joint ventures, outsourcing, 
                and strategic partnerships. Where applicable, OptiStaff ensures consistency of standards across shared operations.
            </p>
        </section>

        <!-- Contact -->
        <section id="contact" class="bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Contact HR</h3>
            <p class="text-gray-600 mb-4">For policy-related queries, please contact our HR department:</p>
            
            <div class="flex justify-center gap-6 text-gray-700">
                <a href="https://wa.me/1234567890" target="_blank" class="hover:text-green-600 transition">
                    <i class="fab fa-whatsapp fa-2x"></i>
                </a>
                <a href="https://facebook.com/OptiStaff" target="_blank" class="hover:text-blue-600 transition">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="mailto:contact@optistaff.com" class="hover:text-red-600 transition">
                    <i class="fas fa-envelope fa-2x"></i>
                </a>
            </div>

            <p class="text-gray-500 mt-6 text-sm">&copy; {{ date('Y') }} OptiStaff HR Management. All rights reserved.</p>
        </section>
    </main>
</div>
@endsection
