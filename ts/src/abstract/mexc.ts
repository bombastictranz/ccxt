// -------------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

// -------------------------------------------------------------------------------

import { implicitReturnType } from '../base/types.js';
import { Exchange as _Exchange } from '../base/Exchange.js';

interface Exchange {
     spotPublicGetPing (params?: {}): Promise<implicitReturnType>;
     spotPublicGetTime (params?: {}): Promise<implicitReturnType>;
     spotPublicGetExchangeInfo (params?: {}): Promise<implicitReturnType>;
     spotPublicGetDepth (params?: {}): Promise<implicitReturnType>;
     spotPublicGetTrades (params?: {}): Promise<implicitReturnType>;
     spotPublicGetHistoricalTrades (params?: {}): Promise<implicitReturnType>;
     spotPublicGetAggTrades (params?: {}): Promise<implicitReturnType>;
     spotPublicGetKlines (params?: {}): Promise<implicitReturnType>;
     spotPublicGetAvgPrice (params?: {}): Promise<implicitReturnType>;
     spotPublicGetTicker24hr (params?: {}): Promise<implicitReturnType>;
     spotPublicGetTickerPrice (params?: {}): Promise<implicitReturnType>;
     spotPublicGetTickerBookTicker (params?: {}): Promise<implicitReturnType>;
     spotPublicGetEtfInfo (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetOpenOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetAllOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetAccount (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMyTrades (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetSubAccountList (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetSubAccountApiKey (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalConfigGetall (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalDepositHisrec (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalWithdrawHistory (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalDepositAddress (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalTransfer (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalSubAccountUniversalTransfer (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalConvert (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetCapitalConvertList (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginLoan (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginAllOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginMyTrades (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginOpenOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginMaxTransferable (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginPriceIndex (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginIsolatedAccount (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginMaxBorrowable (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginRepay (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginIsolatedPair (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginForceLiquidationRec (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginIsolatedMarginData (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMarginIsolatedMarginTier (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetRebateTaxQuery (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetRebateDetail (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetRebateDetailKickback (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetRebateReferCode (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetMxDeductEnable (params?: {}): Promise<implicitReturnType>;
     spotPrivateGetUserDataStream (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostOrderTest (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostSubAccountVirtualSubAccount (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostSubAccountApiKey (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostSubAccountFutures (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostSubAccountMargin (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostBatchOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostCapitalWithdrawApply (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostCapitalTransfer (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostCapitalDepositAddress (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostCapitalSubAccountUniversalTransfer (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostCapitalConvert (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostMarginTradeMode (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostMarginOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostMarginLoan (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostMarginRepay (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostMxDeductEnable (params?: {}): Promise<implicitReturnType>;
     spotPrivatePostUserDataStream (params?: {}): Promise<implicitReturnType>;
     spotPrivatePutUserDataStream (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteOpenOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteSubAccountApiKey (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteMarginOrder (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteMarginOpenOrders (params?: {}): Promise<implicitReturnType>;
     spotPrivateDeleteUserDataStream (params?: {}): Promise<implicitReturnType>;
     contractPublicGetPing (params?: {}): Promise<implicitReturnType>;
     contractPublicGetDetail (params?: {}): Promise<implicitReturnType>;
     contractPublicGetSupportCurrencies (params?: {}): Promise<implicitReturnType>;
     contractPublicGetDepthSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetDepthCommitsSymbolLimit (params?: {}): Promise<implicitReturnType>;
     contractPublicGetIndexPriceSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetFairPriceSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetFundingRateSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetKlineSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetKlineIndexPriceSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetKlineFairPriceSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetDealsSymbol (params?: {}): Promise<implicitReturnType>;
     contractPublicGetTicker (params?: {}): Promise<implicitReturnType>;
     contractPublicGetRiskReverse (params?: {}): Promise<implicitReturnType>;
     contractPublicGetRiskReverseHistory (params?: {}): Promise<implicitReturnType>;
     contractPublicGetFundingRateHistory (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetAccountAssets (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetAccountAssetCurrency (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetAccountTransferRecord (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPositionListHistoryPositions (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPositionOpenPositions (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPositionFundingRecords (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPositionPositionMode (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderListOpenOrdersSymbol (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderListHistoryOrders (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderExternalSymbolExternalOid (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderGetOrderId (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderBatchQuery (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderDealDetailsOrderId (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetOrderListOrderDeals (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPlanorderListOrders (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetStoporderListOrders (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetStoporderOrderDetailsStopOrderId (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetAccountRiskLimit (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetAccountTieredFeeRate (params?: {}): Promise<implicitReturnType>;
     contractPrivateGetPositionLeverage (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPositionChangeMargin (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPositionChangeLeverage (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPositionChangePositionMode (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostOrderSubmit (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostOrderSubmitBatch (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostOrderCancel (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostOrderCancelWithExternal (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostOrderCancelAll (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostAccountChangeRiskLevel (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPlanorderPlace (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPlanorderCancel (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostPlanorderCancelAll (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostStoporderCancel (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostStoporderCancelAll (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostStoporderChangePrice (params?: {}): Promise<implicitReturnType>;
     contractPrivatePostStoporderChangePlanPrice (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketSymbols (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketCoinList (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetCommonTimestamp (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetCommonPing (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketTicker (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketDepth (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketDeals (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketKline (params?: {}): Promise<implicitReturnType>;
     spot2PublicGetMarketApiDefaultSymbols (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAccountInfo (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetOrderOpenOrders (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetOrderList (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetOrderQuery (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetOrderDeals (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetOrderDealDetail (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetDepositAddressList (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetDepositList (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetAddressList (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetWithdrawList (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetInternalTransferRecord (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAccountBalance (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetAssetInternalTransferInfo (params?: {}): Promise<implicitReturnType>;
     spot2PrivateGetMarketApiSymbols (params?: {}): Promise<implicitReturnType>;
     spot2PrivatePostOrderPlace (params?: {}): Promise<implicitReturnType>;
     spot2PrivatePostOrderPlaceBatch (params?: {}): Promise<implicitReturnType>;
     spot2PrivatePostOrderAdvancedPlaceBatch (params?: {}): Promise<implicitReturnType>;
     spot2PrivatePostAssetWithdraw (params?: {}): Promise<implicitReturnType>;
     spot2PrivatePostAssetInternalTransfer (params?: {}): Promise<implicitReturnType>;
     spot2PrivateDeleteOrderCancel (params?: {}): Promise<implicitReturnType>;
     spot2PrivateDeleteOrderCancelBySymbol (params?: {}): Promise<implicitReturnType>;
     spot2PrivateDeleteAssetWithdraw (params?: {}): Promise<implicitReturnType>;
}
abstract class Exchange extends _Exchange {}

export default Exchange