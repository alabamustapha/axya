@extends('layouts.master')

@section('title', $user->name .' - Transactions Dashboard')

@section('page-title', 'Transactions by '. $user->name)

@section('content')





    <div class="row">
        
        <div class="col-md-3">
            <div class="card transaction-menu " >
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a class="nav-link active" id="v-pills-pay-history-tab" data-toggle="pill" href="#v-pills-pay-history" role="tab"
                            aria-controls="v-pills-home" aria-selected="true">Payment History</a>
                        </li>
                        <li class="list-group-item">
                            <a class="nav-link" id="v-pills-pay-method-tab" data-toggle="pill" href="#v-pills-pay-method" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">Payment Method</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-pay-history" role="tabpanel" aria-labelledby="v-pills-pay-history-tab">
                    <div class="transaction-body">
                        <div class="table-responsive-md transaction-table">
                            <table class="table table-borderless">
                                <thead >
                                    <tr>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Paid to</th>
                                        <th scope="col">Date</th>
                                        {{-- <th scope="col">Appointment type</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr title="{{$transaction->appointment->description}}">
                                            
                                            <td>{{ $transaction->appointment->duration }}</td>
                                            <td>{{ $transaction->amount }}</td>
                                            <td>
                                                <span>
                                                    <img src="{{$transaction->doctor->avatar}}" height="25" alt="doctor avatar" class="rounded-circle">
                                                    <a href="{{route('doctors.show', $transaction->doctor)}}">{{$transaction->doctor->name}}</a>
                                                </span>
                                            </td>
                                            <td>{{ $transaction->confirmed_at ?:'--' }}</td>
                                            {{-- <td>{{ $transaction->type }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="border-bottom border-warning mb-2 pb-1">
                                                    <table cols="2" cellspacing="0" cellpadding="0" class="w-100">
                                                        <tbody>
                                                            <tr>
                                                                <td class="bg-info" title="Transactionn ID">
                                                                    <span class="text-bold">ID:&nbsp;</span>
                                                                    <kbd>
                                                                        <a href="{{route('transactions.show', [$transaction->user, $transaction])}}" class="card-link">
                                                                            <i class="fa fa-eye"></i> {{ $transaction->transaction_id }}
                                                                        </a>
                                                                    </kbd>
                                                                </td>
                                                                <td class="text-bold text-white bg-{{$transaction->status_indicator}}">
                                                                    <span class="text-muted text-sm">Status:&nbsp;</span>
                                                                    {{ $transaction->status_text }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="display-1"><i class="fa fa-handshake"></i></div> 

                                                <br>

                                                <p>You have <strong>0</strong> transactions at this time.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="4" class="text-center py-3">{{ $transactions->links() }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-pay-method" role="tabpanel" aria-labelledby="v-pills-pay-method-tab">
                   <div class="transaction-body card p-4">
                        <h5 class="card-title">Payment Method</h5>

                        <div class="paycard">
                            <div class="paycard-detail">
                                <svg width="105" height="34" viewBox="0 0 105 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5938 22.5603L21.0939 8.58228H25.0003L22.5783 22.5603H18.5938Z" fill="#3C58BF" />
                                    <path d="M18.5938 22.5603L21.797 8.58228H25.0003L22.5783 22.5603H18.5938Z" fill="#293688" />
                                    <path
                                        d="M36.6507 8.63759C35.8513 8.3188 34.5723 8 32.9735 8C28.9765 8 26.0987 9.99248 26.0987 12.8617C26.0987 15.0135 28.0971 16.1293 29.6959 16.8466C31.2947 17.5639 31.7744 18.0421 31.7744 18.6797C31.7744 19.6361 30.4953 20.1143 29.3762 20.1143C27.7774 20.1143 26.8981 19.8752 25.5391 19.3173L24.9795 19.0782L24.4199 22.3459C25.3792 22.7444 27.1379 23.1429 28.9765 23.1429C33.2133 23.1429 36.0112 21.1504 36.0112 18.1218C36.0112 16.4481 34.972 15.1729 32.5738 14.1368C31.1349 13.4195 30.2555 13.0211 30.2555 12.3038C30.2555 11.6662 30.975 11.0286 32.5738 11.0286C33.9327 11.0286 34.892 11.2677 35.6115 11.5865L36.0112 11.7459L36.6507 8.63759Z"
                                        fill="#3C58BF" />
                                    <path
                                        d="M36.6507 8.63759C35.8513 8.3188 34.5723 8 32.9735 8C28.9765 8 26.8181 9.99248 26.8181 12.8617C26.8181 15.0135 28.0971 16.1293 29.6959 16.8466C31.2947 17.5639 31.7744 18.0421 31.7744 18.6797C31.7744 19.6361 30.4953 20.1143 29.3762 20.1143C27.7774 20.1143 26.8981 19.8752 25.5391 19.3173L24.9795 19.0782L24.4199 22.3459C25.3792 22.7444 27.1379 23.1429 28.9765 23.1429C33.2133 23.1429 36.0112 21.1504 36.0112 18.1218C36.0112 16.4481 34.972 15.1729 32.5738 14.1368C31.1349 13.4195 30.2555 13.0211 30.2555 12.3038C30.2555 11.6662 30.975 11.0286 32.5738 11.0286C33.9327 11.0286 34.892 11.2677 35.6115 11.5865L36.0112 11.7459L36.6507 8.63759Z"
                                        fill="#293688" />
                                    <path
                                        d="M43.2414 8.58228C42.3198 8.58228 41.6286 8.65993 41.2445 9.5918L35.4844 22.5603H39.6317L40.3997 20.2306H45.3151L45.7759 22.5603H49.4624L46.2367 8.58228H43.2414ZM41.475 17.901C41.7054 17.2021 43.011 13.7852 43.011 13.7852C43.011 13.7852 43.3182 12.931 43.5486 12.3874L43.779 13.7076C43.779 13.7076 44.547 17.2021 44.7007 17.9786H41.475V17.901Z"
                                        fill="#3C58BF" />
                                    <path
                                        d="M44.163 8.58228C43.2414 8.58228 42.5502 8.65993 42.1662 9.5918L35.4844 22.5603H39.6317L40.3997 20.2306H45.3151L45.7759 22.5603H49.4624L46.2367 8.58228H44.163ZM41.475 17.901C41.7822 17.1244 43.011 13.7852 43.011 13.7852C43.011 13.7852 43.3182 12.931 43.5486 12.3874L43.779 13.7076C43.779 13.7076 44.547 17.2021 44.7007 17.9786H41.475V17.901Z"
                                        fill="#293688" />
                                    <path
                                        d="M11.6054 18.2892L11.2171 16.2702C10.5182 13.9405 8.26623 11.3779 5.78125 10.1354L9.27575 22.5603H13.4692L19.7593 8.58228H15.5659L11.6054 18.2892Z"
                                        fill="#3C58BF" />
                                    <path
                                        d="M11.6054 18.2892L11.2171 16.2702C10.5182 13.9405 8.26623 11.3779 5.78125 10.1354L9.27575 22.5603H13.4692L19.7593 8.58228H16.3424L11.6054 18.2892Z"
                                        fill="#293688" />
                                    <path
                                        d="M0.539062 6.58228L1.24318 6.7337C6.25023 7.86942 9.69258 10.7466 11.0226 14.1537L9.61435 7.71799C9.37964 6.80942 8.67552 6.58228 7.81494 6.58228H0.539062Z"
                                        fill="#FFBC00" />
                                    <path
                                        d="M0.539062 6.58228C5.54612 7.72946 9.69258 10.7121 11.0226 14.1537L9.69258 8.72369C9.45788 7.80594 8.67552 7.27059 7.81494 7.27059L0.539062 6.58228Z"
                                        fill="#F7981D" />
                                    <path
                                        d="M0.539062 6.58228C5.54612 7.72946 9.69258 10.7121 11.0226 14.1537L10.0838 11.171C9.84905 10.2533 9.53611 9.33552 8.44082 8.95313L0.539062 6.58228Z"
                                        fill="#ED7C00" />
                                    <path
                                        d="M15.2171 17.964L12.5769 15.3237L11.3344 18.2746L11.0238 16.3333C10.3249 14.0036 8.07286 11.441 5.58789 10.1985L9.08238 22.6233H13.2758L15.2171 17.964Z"
                                        fill="#051244" />
                                    <path d="M22.4389 22.6234L19.0998 19.2065L18.4785 22.6234H22.4389Z" fill="#051244" />
                                    <path
                                        d="M31.3673 17.8087C31.678 18.1193 31.8333 18.3523 31.7556 18.6629C31.7556 19.5948 30.5131 20.0607 29.426 20.0607C27.8729 20.0607 27.0186 19.8278 25.6985 19.2842L25.1549 19.0512L24.6113 22.2351C25.5432 22.6233 27.2516 23.0116 29.0377 23.0116C31.5227 23.0116 33.5417 22.3127 34.7065 21.0702L31.3673 17.8087Z"
                                        fill="#051244" />
                                    <path
                                        d="M35.873 22.6234H39.5228L40.2994 20.2937H45.2693L45.7353 22.6234H49.4627L48.1426 16.9546L43.4833 12.4506L43.7162 13.693C43.7162 13.693 44.4928 17.1875 44.6481 17.9641H41.3866C41.6972 17.1875 42.9397 13.8484 42.9397 13.8484C42.9397 13.8484 43.2503 12.9941 43.4833 12.4506"
                                        fill="#051244" />
                                    <path
                                        d="M76.6433 25.2867C83.626 25.2867 89.2867 19.626 89.2867 12.6433C89.2867 5.66061 83.626 0 76.6433 0C69.6606 0 64 5.66061 64 12.6433C64 19.626 69.6606 25.2867 76.6433 25.2867Z"
                                        fill="#EE0005" />
                                    <path
                                        d="M92.3523 25.2867C99.335 25.2867 104.996 19.626 104.996 12.6433C104.996 5.66061 99.335 0 92.3523 0C85.3696 0 79.709 5.66061 79.709 12.6433C79.709 19.626 85.3696 25.2867 92.3523 25.2867Z"
                                        fill="#F9A000" />
                                    <path
                                        d="M79.709 12.6431C79.709 16.6576 81.5804 20.2347 84.498 22.5507C87.4156 20.2346 89.2871 16.6576 89.2871 12.6431C89.2871 8.62857 87.4157 5.05144 84.498 2.73547C81.5805 5.05163 79.709 8.62867 79.709 12.6431Z"
                                        fill="#FF6300" />
                                    <path
                                        d="M68.9918 29.0797C68.4682 29.0797 67.9446 29.368 67.6293 29.9818C67.4211 29.4492 66.9875 29.0797 66.4459 29.0797C65.8412 29.0797 65.4438 29.413 65.2456 29.7655V29.4402C65.2456 29.2599 65.0473 29.1338 64.8211 29.1338C64.5418 29.1338 64.3516 29.26 64.3516 29.4402V30.9438C64.6539 31.3783 64.9702 31.8028 65.2996 32.2163V30.8578C65.2996 30.2441 65.7151 29.9187 66.1396 29.9187C66.5821 29.9187 66.9785 30.2891 66.9785 30.8488V33.1063C66.9785 33.3225 67.2319 33.4126 67.4481 33.4126C67.6924 33.4126 67.9267 33.3225 67.9267 33.1063V30.8398C67.9267 30.2531 68.3511 29.9097 68.7757 29.9097C69.1911 29.9097 69.6157 30.2351 69.6157 30.8578V33.0973C69.6157 33.2505 69.8409 33.4126 70.0852 33.4126C70.3465 33.4126 70.5628 33.2504 70.5628 33.0973V30.8578C70.5626 29.7204 69.8047 29.0797 68.9918 29.0797Z"
                                        fill="#171614" />
                                    <path
                                        d="M72.8839 29.0797C72.2702 29.0797 71.5203 29.332 71.5203 29.6574C71.5203 29.8736 71.6384 30.1359 71.8637 30.1359C72.0439 30.1359 72.2071 29.8646 72.8658 29.8646C73.5245 29.8646 73.7598 30.3792 73.7598 30.8397V31.0019H73.3624C72.1079 31.0019 71.25 31.2732 71.25 32.2933C71.25 33.1063 71.7916 33.4847 72.4503 33.4847C73.064 33.4847 73.4976 33.1513 73.8139 32.7808V33.0972C73.8139 33.2684 74.0032 33.4125 74.2474 33.4125C74.5087 33.4125 74.7079 33.2683 74.7079 33.0972V30.8307C74.7079 29.9276 74.2114 29.0797 72.8839 29.0797ZM73.7599 31.8599C73.7599 32.2933 73.2453 32.7629 72.7938 32.7629C72.4594 32.7629 72.2072 32.5827 72.2072 32.1763C72.2072 31.5986 72.8479 31.5255 73.5337 31.5255H73.7599V31.8599Z"
                                        fill="#171614" />
                                    <path
                                        d="M76.3679 30.3341C76.3679 30.1088 76.5661 29.8104 77.0987 29.8104C77.6053 29.8104 77.8846 30.0728 78.0738 30.0728C78.3 30.0728 78.4352 29.7474 78.4352 29.6122C78.4352 29.3229 77.7584 29.0796 77.0807 29.0796C75.9434 29.0796 75.537 29.7564 75.537 30.3791C75.537 31.8778 77.7135 31.3181 77.7135 32.2662C77.7135 32.5095 77.5413 32.7538 76.9456 32.7538C76.1697 32.7538 75.9796 32.3383 75.7453 32.3383C75.5551 32.3383 75.4199 32.6007 75.4199 32.7628C75.4199 33.1062 76.0797 33.4846 76.9726 33.4846C77.9929 33.4846 78.5615 32.997 78.5615 32.2302C78.5614 30.6054 76.3679 31.129 76.3679 30.3341Z"
                                        fill="#171614" />
                                    <path
                                        d="M81.2087 32.6008H80.8923C80.4228 32.6008 80.2607 32.4376 80.2607 32.0041V29.8377H81.3619C81.5241 29.8377 81.6242 29.6665 81.6242 29.4853C81.6242 29.3051 81.5241 29.1338 81.3619 29.1338H80.2607V27.481C80.2607 27.3008 80.0163 27.1747 79.7821 27.1747C79.5559 27.1747 79.3125 27.3009 79.3125 27.481V32.0041C79.3125 32.9882 79.8631 33.4127 80.8922 33.4127H81.2086C81.4789 33.4127 81.6141 33.2145 81.6141 33.0063C81.6142 32.799 81.479 32.6008 81.2087 32.6008Z"
                                        fill="#171614" />
                                    <path
                                        d="M85.3506 32.3744C85.1063 32.3744 84.8901 32.7178 84.2494 32.7178C83.5536 32.7178 83.075 32.3384 83.075 31.7337V31.5255H84.9801C85.3866 31.5255 85.8021 31.4985 85.8021 30.7496C85.8021 29.7655 84.9711 29.0797 84.0051 29.0797C82.9668 29.0797 82.127 29.8826 82.127 30.8307V31.6887C82.127 32.7629 82.994 33.4847 84.2224 33.4847C85.1334 33.4847 85.721 33.0692 85.721 32.7988C85.721 32.6367 85.5759 32.3744 85.3506 32.3744ZM83.075 30.6504C83.075 30.1539 83.4995 29.8015 83.996 29.8015C84.5107 29.8015 84.9081 30.1899 84.9081 30.6685C84.9081 30.8847 84.836 30.9387 84.5737 30.9387H83.075V30.6504Z"
                                        fill="#171614" />
                                    <path
                                        d="M88.9 29.0797H88.6106C88.078 29.0797 87.6545 29.4582 87.4643 29.8376V29.4402C87.4643 29.2599 87.2661 29.1338 87.0309 29.1338C86.7606 29.1338 86.5703 29.26 86.5703 29.4402V33.0973C86.5703 33.2505 86.7605 33.4126 87.0309 33.4126C87.3022 33.4126 87.5185 33.2504 87.5185 33.0973V31.2462C87.5185 30.4242 88.0601 29.9187 88.6107 29.9187H88.9001C89.0893 29.9187 89.2615 29.7295 89.2615 29.4943C89.2614 29.2689 89.0892 29.0797 88.9 29.0797Z"
                                        fill="#171614" />
                                    <path
                                        d="M92.5731 32.3474C92.3659 32.3474 92.2217 32.6457 91.6251 32.6457C90.9302 32.6457 90.623 32.2843 90.623 31.6887V30.8757C90.623 30.28 90.9393 29.9186 91.6161 29.9186C92.1948 29.9186 92.3569 30.199 92.5461 30.199C92.7723 30.199 92.9255 29.9186 92.9255 29.7384C92.9255 29.422 92.3659 29.0797 91.5439 29.0797C90.2534 29.0797 89.6758 29.8646 89.6758 30.8757V31.6887C89.6758 32.7179 90.2534 33.4847 91.5529 33.4847C92.3839 33.4847 92.9796 33.1152 92.9796 32.7988C92.9797 32.6097 92.8265 32.3474 92.5731 32.3474Z"
                                        fill="#171614" />
                                    <path
                                        d="M95.0304 29.0797C94.4167 29.0797 93.6668 29.332 93.6668 29.6574C93.6668 29.8736 93.7849 30.1359 94.0102 30.1359C94.1913 30.1359 94.3536 29.8646 95.0123 29.8646C95.671 29.8646 95.9063 30.3792 95.9063 30.8397V31.0019H95.5089C94.2544 31.0019 93.3965 31.2732 93.3965 32.2933C93.3965 33.1063 93.9381 33.4847 94.5968 33.4847C95.2115 33.4847 95.644 33.1513 95.9604 32.7808V33.0972C95.9604 33.2684 96.1496 33.4125 96.3939 33.4125C96.6551 33.4125 96.8544 33.2683 96.8544 33.0972V30.8307C96.8544 29.9276 96.3578 29.0797 95.0304 29.0797ZM95.9064 31.8599C95.9064 32.2933 95.3918 32.7629 94.9403 32.7629C94.6059 32.7629 94.3536 32.5827 94.3536 32.1763C94.3536 31.5986 94.9943 31.5255 95.6802 31.5255H95.9064V31.8599Z"
                                        fill="#171614" />
                                    <path
                                        d="M100.147 29.0797H99.8587C99.3261 29.0797 98.9016 29.4582 98.7124 29.8376V29.4402C98.7124 29.2599 98.5132 29.1338 98.2789 29.1338C98.0076 29.1338 97.8184 29.26 97.8184 29.4402V33.0973C97.8184 33.2505 98.0076 33.4126 98.2789 33.4126C98.5492 33.4126 98.7665 33.2504 98.7665 33.0973V31.2462C98.7665 30.4242 99.3081 29.9187 99.8588 29.9187H100.147C100.337 29.9187 100.508 29.7295 100.508 29.4943C100.508 29.2689 100.337 29.0797 100.147 29.0797Z"
                                        fill="#171614" />
                                    <path
                                        d="M104.174 26.5879C103.904 26.5879 103.695 26.7141 103.695 26.8942V29.7655C103.497 29.4131 103.091 29.0797 102.522 29.0797C101.637 29.0797 100.906 29.8826 100.906 30.8576V31.6886C100.906 32.6277 101.646 33.4846 102.495 33.4846C102.537 33.4846 102.578 33.4826 102.619 33.4786C103.348 32.6807 104.025 31.8337 104.644 30.9447V26.8943C104.644 26.7141 104.445 26.5879 104.174 26.5879ZM103.696 31.896C103.696 32.1132 103.29 32.6458 102.765 32.6458C102.269 32.6458 101.854 32.1762 101.854 31.6887V30.8577C101.854 30.3882 102.269 29.9187 102.775 29.9187C103.226 29.9187 103.696 30.2711 103.696 30.8577V31.896Z"
                                        fill="#171614" />
                                </svg>

                            </div>
                            <div class="paycard-detail">
                                <p class="paycard-detail--title">Card Number</p>
                                <p class="paycard-detail--info">53610600XXXXXXXXX</p>
                            </div>
                            <div class="paycard-detail">
                                <p class="paycard-detail--title">Expiration Date</p>
                                <p class="paycard-detail--info">01/2022</p>
                            </div>
                        </div>

                        <a href="#" class="btn btn-primary">Change Payment Method</a>
                        
                   </div>
                </div>
        
            </div>
        </div>

        
    </div>


@endsection