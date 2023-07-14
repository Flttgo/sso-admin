<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $user_id PK
 * @property string $user_uuid UUID
 * @property string $user_username 用户名
 * @property string $user_name 姓名
 * @property string|null $user_sso_no 员工编号，对接统一认证中心
 * @property string $user_mobile 手机号
 * @property string $user_email 邮箱
 * @property string $user_avatar 头像
 * @property string $user_auth_key 认证密钥
 * @property string|null $user_token_id 用户token
 * @property string $user_password_hash 密码hash
 * @property string $user_password_reset_token 重置密码token
 * @property string $user_verification_token 激活token
 * @property int $user_status 状态 0:待激活,1:激活,2:停用
 * @property string $user_audit_status 审核状态:new-待审核;pass-通过;refuse-拒绝
 * @property string|null $user_remark 备注
 * @property mixed|null $user_extra 扩展数据
 * @property string $user_current_organization_code 用户当前机构编码
 * @property string $user_expire_type 用户过期类型:permanent 永久, customize 自定义
 * @property string|null $user_expire_start_time 用户有效期开始时间
 * @property string|null $user_expire_end_time 用户有效期结束时间
 * @property string $user_create_by 创建人
 * @property string $user_create_at 创建时间
 * @property string $user_update_by 更新人
 * @property string $user_update_at 更新时间
 * @property string|null $user_cert_no 身份证号
 * @property int|null $user_sso_pw_init sso 授权密码是否初始化 1 初始化 0 正常
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAuditStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAuthKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCertNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCreateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCreateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCurrentOrganizationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserExpireEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserExpireStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserExpireType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPasswordResetToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserSsoNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserSsoPwInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUpdateBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserVerificationToken($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

