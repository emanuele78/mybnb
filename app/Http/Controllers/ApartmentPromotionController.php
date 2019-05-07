<?php
	
	namespace App\Http\Controllers;
	
	use App\Apartment;
	use App\Http\Requests\CheckPromotionRequest;
	use App\Http\Requests\StorePromotionRequest;
	use App\Promotion;
	use App\PromotionPlan;
	use App\Services\BraintreeGateway;
	use Barryvdh\DomPDF\Facade as PDF;
	use Auth;
	
	class ApartmentPromotionController extends Controller {
		
		/**
		 * Return the form to create a new promotion together with a list of apartment related promotions
		 *
		 * @param Apartment $apartment
		 * @return mixed
		 */
		public function create(Apartment $apartment) {
			
			//need some check before proceed
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (!Auth::user()->isCustomer()) {
				return redirect()->route('register_customer');
			}
			if (Auth::user()->id != $apartment->owner()->id) {
				return abort(403);
			}
			
			return view('layouts.promotion')
			  ->withApartment($apartment)
			  ->withPromotionsList(Promotion::listFor($apartment->id))
			  ->withPlans(PromotionPlan::available())
			  ->withActivePromotion($apartment->activePromotion());
		}
		

		public function show(Promotion $promotion) {
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			if (Auth::user()->id != $promotion->apartment->owner()->id) {
				return abort(403);
			}
			$pdf = PDF::loadView('pdf.promo_receipt', $promotion->dataForInvoice());
			return $pdf->stream('invoice.pdf');
		}
		
		/**
		 * Perform the payment and store the promotion
		 *
		 * @param Apartment $apartment
		 * @param StorePromotionRequest $request
		 * @param BraintreeGateway $braintreeGateway
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function store(Apartment $apartment, StorePromotionRequest $request, BraintreeGateway $braintreeGateway) {
			
			$validated = $request->validated();
			if (Promotion::overlaps($apartment->id, $validated['start_at'], $validated['day_length'])) {
				return response()->json(['success' => false, 'message' => 'braintree_error'], 404);
			}
			$promo_amount = Promotion::calcPrice($validated['day_length'], $validated['card_type']);
			$transactionResult = $braintreeGateway->performPayment($promo_amount, $validated['paymentMethodNonce']);
			if ($transactionResult) {
				Promotion::createFor($apartment->id, $validated['start_at'], $validated['day_length'], $validated['card_type'], $promo_amount);
				return response()->json(['success' => true], 200);
			} else {
				return response()->json(['success' => false, 'message' => 'braintree_error'], 500);
			}
		}
		
		/**
		 * Check if new user promotion overlaps existing promotios for same apartment
		 *
		 * @param Apartment $apartment
		 * @param CheckPromotionRequest $request
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function index(Apartment $apartment, CheckPromotionRequest $request) {
			
			$validated = $request->validated();
			$overlaps = Promotion::overlaps($apartment->id, $validated['start_at'], $validated['day_length']);
			return response()->json(['success' => true, 'overlaps' => $overlaps], 200);
		}
	}
