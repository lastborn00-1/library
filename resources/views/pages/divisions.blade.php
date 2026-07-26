@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="mb-12 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900">Library Divisions</h1>
        <p class="mt-4 text-xl text-slate-500">Discover the structure and services that power the Kwara State College of Health Technology Library.</p>
    </div>

    <div class="space-y-16">
        
        <!-- Technical Services Division -->
        <div id="technical" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden scroll-mt-24">
            <div class="bg-indigo-50 px-8 py-6 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-indigo-900">Technical Services Division</h2>
            </div>
            <div class="p-8 text-slate-700 leading-relaxed">
                <p class="mb-6">
                    The Technical Services Division is normally headed by a Deputy College Librarian as Technical Services Librarian. The Division comprises Acquisitions, Cataloguing and Classification Sections, Serials and Bindery Unit. The primary responsibility of the division is to coordinate activities that take place in the sections.
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Acquisitions Section</h3>
                <p class="mb-4">Major routines performed in the Section include:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Collection development i.e. procurement of books through purchases, donations, gifts and endowment;</li>
                    <li>Keeping records of books purchased;</li>
                    <li>Verification of books on order;</li>
                    <li>Accessioning and stamping of books purchased;</li>
                    <li>Facilitating book purchases between Library clientele and Publishers for personal use; and</li>
                    <li>Preparation of lists of new arrivals (books).</li>
                </ul>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Cataloguing and Classification Section</h3>
                <p class="mb-4">This section is charged with the responsibilities to:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Catalog Library materials;</li>
                    <li>Classify Library materials;</li>
                    <li>Manually and electronically create and maintain records of the Library’s holdings;</li>
                    <li>Label Library materials; and</li>
                    <li>Move the processed materials to their designated sections (e.g. Circulation, Reference and Serials).</li>
                </ul>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Serials Section</h3>
                <p class="mb-4">The section is manned by the Serials Librarian. The main routines and services in the Serials Section include:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Procurement of journals, newspapers and magazines through subscriptions or donations;</li>
                    <li>Processing of Serials for the use of the clientele;</li>
                    <li>Arrangement of Serials on the shelves;</li>
                    <li>Making Serials available to users on demand;</li>
                    <li>Keeping statistics and generate reports of users of Serials;</li>
                    <li>Displaying current Serials;</li>
                    <li>Providing current awareness services; and</li>
                    <li>Maintaining bibliographic details of Serials in the Kardex as well as Serials card catalog.</li>
                </ul>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Bindery Section</h3>
                <p class="mb-4">The services of the Bindery Section include:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>General book binding for the Library, other departments and offices of the College, and individuals of the College community and outside;</li>
                    <li>Cutting of the catalog cards, for both the Library and its clientele’s use;</li>
                    <li>Training of students of Library and Information Science on Industrial Training (IT) under the SIWES programme, to update their practical knowledge in the area of book-binding and preservation;</li>
                    <li>Lamination of papers and documents like certificates and identity cards for the individuals within the college community and beyond; and</li>
                    <li>Other essential and emergency services, as may be assigned to the Head of the Section, by the College Librarian, like the binding of accreditation papers and other services.</li>
                </ul>
            </div>
        </div>

        <!-- Readers' Services Division -->
        <div id="readers" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden scroll-mt-24">
            <div class="bg-indigo-50 px-8 py-6 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-indigo-900">Readers' Services Division</h2>
            </div>
            <div class="p-8 text-slate-700 leading-relaxed">
                <p class="mb-6">
                    This division establishes direct contact with the Library users. It takes custody of materials that have been processed in the Technical Services Division and makes them available to users in an organized and controlled system. The division is usually headed by a Deputy College Librarian. The division coordinates the activities of the sections under it.
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Circulation Section</h3>
                <p class="mb-4">This is one of the public relations sections of the Library. The head of the section is usually Circulation Librarian. The Circulation Section has the responsibilities to:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Register new Library users;</li>
                    <li>Charge books out to users;</li>
                    <li>Discharge returned books;</li>
                    <li>Keep statistics and generate reports of Library users and Library materials consulted;</li>
                    <li>Display and shelve new books;</li>
                    <li>Re-shelve used books;</li>
                    <li>Conduct shelf-reading;</li>
                    <li>Maintain books on the open shelves; and</li>
                    <li>Maintain books on reserved and other closed access shelves and keep records of usage.</li>
                </ul>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Reference Section</h3>
                <p class="mb-4">This section is headed by a Reference Librarian. Reference materials are meant for consultation only and are therefore not to be borrowed or taken out of the library. Like the Circulation Section, this section is also a public relations section of the Library. Therefore, the Reference Section:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Provides answers to Reference queries;</li>
                    <li>Maintains Reference collection on closed shelves;</li>
                    <li>Provides answers to directional and non-directional queries;</li>
                    <li>Processes inter-library requests;</li>
                    <li>Teaches clientele how to use special Reference materials; and</li>
                    <li>Maintains statistics and generates reports of Reference materials consulted.</li>
                </ul>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Documents Section</h3>
                <p class="mb-4">The Documents Section houses government publications and other publications emanating from corporate bodies. The section is headed by a Librarian, with functions which include:</p>
                <ul class="list-disc pl-6 space-y-2 mb-6">
                    <li>Harvesting of documents from government agencies and corporate bodies;</li>
                    <li>Classifying the harvested publications;</li>
                    <li>Maintaining the records of documents in the section;</li>
                    <li>Ensuring that documents are made available to users on request; and</li>
                    <li>Keeping statistics and generating reports of documents consulted.</li>
                </ul>
                <p>
                    Documents can only be consulted in this section except for the purpose of photocopying. However, permission must be sought from the Librarian in charge of the section before such documents can be taken out of the purpose of photocopying.
                </p>
            </div>
        </div>

        <!-- Electronic Support Services Division -->
        <div id="electronic" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden scroll-mt-24">
            <div class="bg-indigo-50 px-8 py-6 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-indigo-900">Electronic Support Services Division</h2>
            </div>
            <div class="p-8 text-slate-700 leading-relaxed">
                <p class="mb-6">
                    This division ensures that all manually handled library services are carried out electronically. The division oversees four Sections, namely:
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Library Automation / Online Public Access Catalog (OPAC)</h3>
                <p class="mb-6">
                    This section ensures that bibliographic details of all library materials and information about the patrons of the Library are carefully uploaded unto the Library server by the Circulation and Technical Sections of the Library. The section handles all technical challenges that may crop up while inputting bibliographic details of the Library resources into the server; attends to challenges resulting from system upgrading and also maintains server operations. You can access the holdings of the College Library through our Online Public Access Catalog (OPAC).
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Online Institutional Repository</h3>
                <p class="mb-6">
                    This section is responsible for creating, developing and maintaining the Institutional Repository system, which contains the intellectual properties of the College. It is an open-access system, which staff and students can access for research, teaching and learning.
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Electronic Library</h3>
                <p class="mb-6">
                    This section directly assists students and staff to use the computer facilities to access the Internet; provides wireless Internet services and provides access to the subscribed and free databases of the Library for their research. The section develops and implements training programmes for students and staff on the search for qualitative academic e-journals and e-books from the e-library.
                </p>

                <h3 class="text-xl font-bold text-slate-900 mt-8 mb-4">Media Production Unit</h3>
                <p class="mb-6">
                    This section is saddled with the responsibility of providing a wide range of recordings and production services to the College staff and students, and maintaining audio-visual equipment in all multimedia sections of the Library. The section is equipped with audio sets, headphones, Plasma TVs, video cameras, audio tapes and recorders, CD-ROM, VCD, and DVD production equipment. There is provision for a media room for recording at each location. Reservations for use of the media room and other specialized services requiring bookings would be available on request.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
