@extends('layouts.app')

@section('title', 'Company Policy - OptiStaff')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12 text-center shadow-md rounded-lg mb-10">
        <h1 class="text-3xl font-bold mb-2">OptiStaff HR Policies</h1>
        <p class="text-lg text-gray-200 max-w-2xl mx-auto">
            Our policies ensure transparency, fairness, and professionalism in the workplace.
        </p>
    </div>

    <!-- Policy Content -->
    <div class="container mx-auto max-w-4xl bg-white rounded-lg shadow-md p-8 space-y-8">
        
        <!-- Introduction -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Introduction</h2>
            <p class="text-gray-600 leading-relaxed">
                This document outlines the official policies of OptiStaff HR Management System. 
                All employees and stakeholders are expected to comply with the following policies 
                to maintain a professional and respectful workplace environment.
            </p>
        </div>

        <!-- Section 1 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">1. Employee Conduct</h2>
            <p class="text-gray-600 leading-relaxed">
                All employees are expected to maintain integrity, respect, and professionalism. 
                Misconduct, harassment, or unethical practices will not be tolerated and may lead to disciplinary actions.
            </p>
        </div>

        <!-- Section 2 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">2. Attendance Policy</h2>
            <p class="text-gray-600 leading-relaxed">
                Employees must record accurate attendance using the OptiStaff system. 
                Unauthorized absences, habitual lateness, or misuse of leave policies will be reviewed by HR.
            </p>
        </div>

        <!-- Section 3 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">3. Leave & Holidays</h2>
            <p class="text-gray-600 leading-relaxed">
                Employees can request leave through the system. Requests must be approved by the reporting manager. 
                Company-wide holidays are published annually and visible in the HR portal.
            </p>
        </div>

        <!-- Section 4 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">4. Data Protection & Privacy</h2>
            <p class="text-gray-600 leading-relaxed">
                OptiStaff values data confidentiality. Sharing, selling, or misusing company or employee information 
                is strictly prohibited and may result in termination or legal action.
            </p>
        </div>

        <!-- Section 5 -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">5. Code of Ethics</h2>
            <p class="text-gray-600 leading-relaxed">
                We uphold ethical behavior in all dealings. Conflicts of interest, bribery, or discrimination 
                are against company principles and subject to disciplinary measures.
            </p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container mx-auto max-w-4xl mt-10 text-center">
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Contact Us</h3>
            <p class="text-gray-600 mb-4">For any policy-related queries, feel free to reach out:</p>
            
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
        </div>
    </div>

</div>
@endsection
